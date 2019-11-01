var plugin_client_egrul = function(){
    var base_url     =  window.location.origin+'/plugins';

    return {
        autofill : function (elements, step, handler) {
            if ($('input[name="'+handler+'"]').val() && elements.hasOwnProperty('inn')){
                $.post(
                    base_url+'/egrulreq',
                    {k:$('input[name="'+handler+'"]').val()},
                    function (data) {
                        if (parseInt(data) !== 0 ) {
                            $('#step-' + step).find('input').each(function (i, inp) {
                                // if (elements.inn == $(inp).prop('name')){
                                //     $(inp).val(data.INN);
                                // }
                                if (elements.addr == $(inp).prop('name')) {
                                    $(inp).val(data.a);
                                }
                                if (elements.cdata == $(inp).prop('name')) {
                                    $(inp).val(data.r);
                                }
                                if (elements.kpp == $(inp).prop('name')) {
                                    $(inp).val(data.p);
                                }
                                if (elements.ogrn == $(inp).prop('name')) {
                                    $(inp).val(data.o);
                                }
                                if (elements.oname == $(inp).prop('name')) {
                                    $(inp).val(data.c);
                                }
                                if (elements.otype == $(inp).prop('name')) {
                                    $(inp).val(data.k);
                                }
                                if (elements.status == $(inp).prop('name')) {
                                    $(inp).val(data.g);
                                }
                            });

                            $('#step-' + step).find('select').each(function (i, inp) {
                                if (elements.otype == $(inp).prop('name')) {
                                    $(inp).val((data.k === 'ul'?'Юридическое лицо':'Физическое лицо'));
                                }
                            });

                        } else {
                            $('<div id="dialog-confirm" title="ИНН не найден"><p>Указанный ИНН не найден в базе ЕГРЮЛ</p></div>').dialog({
                                resizable: false,
                                height: 'auto',
                                width: 'auto',
                                modal: true,
                                buttons:{
                                    Ok: function() {
                                        $( this ).dialog('close');
                                    }
                                }
                            });
                        }
                    }
                );
            }

            return;
        },
    };
}();
