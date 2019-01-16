var plugin_egrul = function(){
    var base_url =  window.location.origin+'/plugins';

    function __loadScriptforTemplate(tid) {
        $.post(base_url+'/getscript', {t:tid}, function (list) {
            $('.tg-plugin-egrul-script').empty();
            $('.tg-plugin-egrul-script').append('<tr><th>ИНН</th><th>Название орг.</th><th>Адрес</th><th>Должность</th><th>ОГРН</th><th>Дата рег.</th><th>КПП</th><th>Форма</th><th><i class="fa fa-trash-o" aria-hidden="true"></i></th></tr>');

            $(list).each(function (it) {
                list[it].inn_text = $('select[name=inn]').find('option[value='+list[it].inn+']').text();
                list[it].oname_text = $('select[name=oname]').find('option[value='+list[it].oname+']').text();
                list[it].addr_text = $('select[name=addr]').find('option[value='+list[it].addr+']').text();
                list[it].status_text = $('select[name=status]').find('option[value='+list[it].status+']').text();
                list[it].ogrn_text = $('select[name=ogrn]').find('option[value='+list[it].ogrn+']').text();
                list[it].cdata_text = $('select[name=cdata]').find('option[value='+list[it].cdata+']').text();
                list[it].kpp_text = $('select[name=kpp]').find('option[value='+list[it].kpp+']').text();
                list[it].otype_text = $('select[name=otype]').find('option[value='+list[it].otype+']').text();

                $('.tg-plugin-egrul-script').append('<tr onclick="plugin_egrul.setEditSelectedScript(this)"><td data-inn="'+list[it].inn+'">'+list[it].inn_text+'</td><td data-oname="'+list[it].oname+'">'+list[it].oname_text+'</td><td data-addr="'+list[it].addr+'">'+list[it].addr_text+'</td><td data-status="'+list[it].status+'">'+list[it].status_text+'</td><td data-ogrn="'+list[it].ogrn+'">'+list[it].ogrn_text+'</td><td data-cdata="'+list[it].cdata+'">'+list[it].cdata_text+'</td><td data-kpp="'+list[it].kpp+'">'+list[it].kpp_text+'</td><td data-otype="'+list[it].otype+'">'+list[it].otype_text+'</td><td data-tid="'+tid+'" data-inn="'+list[it].inn+'" onclick="plugin_egrul.deleteScript(this)"><i class="fa fa-times" aria-hidden="true"></i></td></tr>');
            });

            $('.tg-plugin-egrul-script').show();
        });
    }

    function __clearFields() {
        $('select[name=inn]').empty();
        $('select[name=oname]').empty();
        $('select[name=addr]').empty();
        $('select[name=status]').empty();
        $('select[name=ogrn]').empty();
        $('select[name=cdata]').empty();
        $('select[name=kpp]').empty();
        $('select[name=otype]').empty();

        $('select[name=inn]').append($('<option></option>').attr('value', 0).text('Не задано'));
        $('select[name=oname]').append($('<option></option>').attr('value', 0).text('Не задано'));
        $('select[name=addr]').append($('<option></option>').attr('value', 0).text('Не задано'));
        $('select[name=status]').append($('<option></option>').attr('value', 0).text('Не задано'));
        $('select[name=ogrn]').append($('<option></option>').attr('value', 0).text('Не задано'));
        $('select[name=cdata]').append($('<option></option>').attr('value', 0).text('Не задано'));
        $('select[name=kpp]').append($('<option></option>').attr('value', 0).text('Не задано'));
        $('select[name=otype]').append($('<option></option>').attr('value', 0).text('Не задано'));
    }

    function __setTemplateVars (tid) {
        $.post(base_url+'/gettemplvars', {t:tid}, function (list) {
            $('.tg-plugin-egrul-script').hide();
            __clearFields();

            $(list).each(function (it) {
                $('select[name=inn]').append($('<option></option>').attr('value', list[it].aid).text(list[it].adesc));
                $('select[name=oname]').append($('<option></option>').attr('value', list[it].aid).text(list[it].adesc));
                $('select[name=addr]').append($('<option></option>').attr('value', list[it].aid).text(list[it].adesc));
                $('select[name=status]').append($('<option></option>').attr('value', list[it].aid).text(list[it].adesc));
                $('select[name=ogrn]').append($('<option></option>').attr('value', list[it].aid).text(list[it].adesc));
                $('select[name=cdata]').append($('<option></option>').attr('value', list[it].aid).text(list[it].adesc));
                $('select[name=kpp]').append($('<option></option>').attr('value', list[it].aid).text(list[it].adesc));
                $('select[name=otype]').append($('<option></option>').attr('value', list[it].aid).text(list[it].adesc));
            });

            __loadScriptforTemplate(tid);
        });
    }

    function __saveTemplateVars(tid) {
        $.post(base_url+'/savetemplvars', {
            t:tid,
            inn:$('select[name=inn]').val(),
            oname:$('select[name=oname]').val(),
            addr:$('select[name=addr]').val(),
            st:$('select[name=status]').val(),
            ogrn:$('select[name=ogrn]').val(),
            cdata:$('select[name=cdata]').val(),
            kpp:$('select[name=kpp]').val(),
            otype:$('select[name=otype]').val(),
        }, function (status) {
            __loadScriptforTemplate(tid);
        });
    }

    return {
        loadScriptForFields : function (obj) {

            if ($(obj).val() != 0){
                $('#save_prms').removeClass('disabled');
                __setTemplateVars($(obj).val());
            } else {
                $('#save_prms').addClass('disabled');
                __clearFields();
            }

            return;
        },
        saveScriptForFields : function () {
            __saveTemplateVars($('select[name=temps]').val());

        },
        setEditSelectedScript : function (obj) {
            $(obj).children('td').each(function (it, o) {
                var key = Object.keys($(o).data())[0];
                var val = Object.values($(o).data())[0];

                $('select[name='+key+']').val(val);
            });
        },
        deleteScript : function (obj) {
            $.post(base_url+'/delscript', {t:$(obj).data('tid'), i:$(obj).data('inn')}, function (res) {
                __clearFields();
                __loadScriptforTemplate($(obj).data('tid'));
            });
        }

    };
}();