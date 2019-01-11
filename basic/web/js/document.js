var documentGen = function(){
    var base_url =  window.location.origin+window.location.pathname;
    var DKey = null;

    return {
        saveDocument : function () {
            var masterData = [];

            var values = $('#docMasterHolder').find('input');
            $(values).each(function (it) {
                if ($(values[it]).attr('type') == 'radio' && values[it].checked) {
                    masterData.push({name:$(values[it]).attr('name'), val:$(values[it]).val()});
                } else if ($(values[it]).attr('type') == 'checkbox') {
                    masterData.push({name:$(values[it]).attr('name'), val:($(values[it]).val().toLowerCase() == 'on' ? 1:0)});
                } else if ($(values[it]).attr('type') == 'text') {
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

            $.post(base_url+'/savedocument', {t:$('input[name=tid]').val(), v:JSON.stringify(masterData)}, function (key) {
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
        }
    };
}();