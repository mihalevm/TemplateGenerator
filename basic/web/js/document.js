var documentGen = function(){
    var base_url =  window.location.origin+window.location.pathname;
    var DKey = null;

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    return {
        saveDocument : function () {
            var masterData = [];

            var values = $('#docMasterHolder').find('input');
            $(values).each(function (it) {
                if ($(values[it]).attr('type') == 'radio' && values[it].checked) {
                    masterData.push({name:$(values[it]).attr('name'), val:$(values[it]).val()});
                } else if ($(values[it]).attr('type') == 'checkbox') {
                    masterData.push({name:$(values[it]).attr('name'), val:($(values[it]).val().toLowerCase() == 'on' ? 1:0)});
                } else if ($(values[it]).attr('type') == 'text' && !$(values[it]).data('type')) {
                    masterData.push({name:$(values[it]).attr('name'), val:$(values[it]).val()});
                }
            });

            values = $('#docMasterHolder').find('textarea');
            $(values).each(function (it) {
                masterData.push({name:$(values[it]).attr('name'), val:$(values[it]).val()});
            });

            values = $('#docMasterHolder').find('select');
            $(values).each(function (it) {
                masterData.push({name:$(values[it]).attr('name'), val:$(values[it]).val()});
            });

            values = $('#docMasterHolder').find('table');
            var var_name = null;
            $(values).each(function (it) {
                if ( $(values[it]).parent().attr('name') ) {
                    var_name = $(values[it]).parent().attr('name');
                    var input_fields = $(values[it]).find('input');
                    var input_field_pairs = '';
                    $(input_fields).each(function (inp_f) {
                        input_field_pairs = input_field_pairs+$(input_fields[inp_f]).attr('name')+':'+$(input_fields[inp_f]).val()+';';
                    });
                    if (input_field_pairs) {
                        masterData.push({name:var_name, val:input_field_pairs});
                    }
                }
            });

            $.post(base_url+'/savedocument', {t:$('input[name=tid]').val(), v:JSON.stringify(masterData), e:getCookie('email'), p:getCookie('phone')}, function (key) {
                DKey = key;
                $('#master_doc_finish').hide();
                $('#master_doc_preview').show();
            })

            return;
        },
        previewDocument : function () {
            if ( DKey ) {
                var link=document.createElement('a');
                document.body.appendChild(link);
                link.setAttribute('target', '_blank');
                link.href=base_url+'/previewdocument?k='+DKey;
                link.click();
            }
        },
        create : function () {
            var tid   = $('select[name=template]').val();
            var email = $('input[name=email]').val();
            var phone = $('input[name=phone]').val();

            if (!email){
                $('input[name=email]').addClass('has-error');
                return false;
            }

            if (!phone){
                $('input[name=phone]').addClass('has-error');
                return false;
            }

            if (parseInt(tid) > 0 ){
                document.cookie = 'email='+email;
                document.cookie = 'phone='+phone;
                window.open(window.location.origin + '/document?t=' + tid, '_self');
            }
        }
    };
}();