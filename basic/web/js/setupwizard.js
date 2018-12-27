var setupwizard = function(){
    var base_url =  window.location.toString();
    var wizard_tree = $('.tree');
    var node_idx = 1;
    var root_node_idx = 1;
    var tvars = {};

    function __getAllAttrs(str) {
        var re = /\{(\w+)\}/g;
        var ret = '';
        var m;
        do {m = re.exec(str); if (m) { ret = ret+m[1]+';'; } } while (m);

        ret = ret.slice(0, -1);

        return ret;
    }

    return {
        addStep : function(){
            $(wizard_tree)
                .append('<tr class="treegrid-'+node_idx+'"><td>Шаг '+root_node_idx+'</td><td><div class="tg-wizard-tree-control"><i class="fa fa-times" aria-hidden="true"></div></td></tr>');

            var node_item = node_idx;

            $('.treegrid-'+node_item).find('.tg-wizard-tree-control').click(function () {
                $(wizard_tree).find('.treegrid-parent-'+node_item).remove();
                $(wizard_tree).find('.treegrid-'+node_item).remove();
                root_node_idx--;

                var rootNodes = $(wizard_tree).treegrid('getRootNodes');

                $(rootNodes).each(function (root) {
                    $(rootNodes[root]).find('td:first').text('Шаг '+(root+1));
                });

                $(wizard_tree).treegrid();
            });

            root_node_idx++;
            node_idx++;
            $(wizard_tree)
                .append('<tr class="treegrid-'+node_idx+' treegrid-parent-'+(node_idx-1)+'"><td><select class=""></select></td><td><div class="tg-wizard-tree-control" title="Добавить значение"><i class="fa fa-plus" aria-hidden="true"/></div></td></tr>')

            $('.treegrid-parent-'+node_item).find('.tg-wizard-tree-control').click(function (obj) {

                var name = $('.treegrid-parent-'+node_item).find('select option:selected').text();
                var val  = $('.treegrid-parent-'+node_item).find('select option:selected').val();

                if (name && val) {
                    $('.treegrid-parent-' + node_item + ':last').before('<tr class="treegrid-' + node_idx + ' treegrid-parent-' + node_item + '"><td>' + val + '</td><td>' + name + '</td><td><div class="tg-wizard-tree-control" title="Удалить переменную"><i class="fa fa-times" aria-hidden="true"/></div></td></tr>');
                    $('.treegrid-' + node_idx).find('.tg-wizard-tree-control').click(function (obj) {
                        $(obj.currentTarget).parent().parent().remove();
                    });

                    node_idx++;

                    $(wizard_tree).treegrid();
                }
            });

            for (var attr_key in tvars){
                if (tvars.hasOwnProperty(attr_key)){
                    $('.treegrid-parent-'+(node_idx-1)).find('select:first').append('<option value="'+attr_key+'">'+tvars[attr_key]+'</option>');
                }
            }

            node_idx++;

            $(wizard_tree).treegrid();
        },

        saveWizardSteps : function (cont = false){
            var rootNodes = $(wizard_tree).treegrid('getRootNodes');
            var rootIdx   = 1;
            var save_data = [];

            $(rootNodes).each(function (root) {
                var childNodes = $(rootNodes[root]).treegrid('getChildNodes');
                var root_is_empty = true;

                $(childNodes).each(function (child) {
                    if ( $(childNodes[child]).find('select').length == 0 ) {
                        root_is_empty = false;
                        var values = $(childNodes[child]).find('td');
                        save_data.push({s:rootIdx, p:child+1, v:$(values[0]).text()});
                    }
                });

                if (!root_is_empty){
                    rootIdx++;
                }

            });

            // console.log(JSON.stringify(save_data));

            $.post(base_url+'/savewizard', {t:$('input[name=tid]').val(), w:JSON.stringify(save_data)}, function (data) {
                if (!cont) {setupwizard.cancelSelectedItem();}
            });
        },
        editSelectedItem : function () {
            if ($('input[name=tid]').val()) {
                $.post(base_url + '/getattr', {t:$('input[name=tid]').val()}, function (attr) {
                    tvars = attr;
                    $.post(base_url + '/getwizard', {t:$('input[name=tid]').val()}, function (wizard) {
                        var steps = [];
                        var selector = [];
                        var bnt = [];
                        $(wizard).each(function (it) {
                            if (!steps.includes(wizard[it].step)){
                                setupwizard.addStep();
                                steps.push(wizard[it].step);
                                selector.push($('.treegrid-'+(node_idx-1)).find('select:first'));
                                bnt.push($('.treegrid-'+(node_idx-1)).find('.tg-wizard-tree-control:first'));
                            }

                            $(selector[wizard[it].step-1]).val(wizard[it].aname);
                            $(bnt[wizard[it].step-1]).click();
                        });

                        $('div#editor-holder').show();
                        $('div#tmpl_list_holder').hide();
                        $('.breadcrumb').append('<li>' + $('input[name=tname]').val() + '</li>');
                    });
                });
            }
        },

        setActiveItem : function (obj) {
            $(obj).parent().find('.tg-attr-item-active').removeClass('tg-attr-item-active');
            $(obj).addClass('tg-attr-item-active');
            $('input[name=tid]').val($(obj).data('tid'));
            $('input[name=tname]').val($(obj).data('tname'));
        },

        cancelSelectedItem : function () {
            $('div#editor-holder').hide();
            $('div#froala-editor').froalaEditor('destroy');
            $('div#froala-editor').html('');
            $('div#tmpl_list_holder').show();
            $('.breadcrumb li:last').remove();
            $.pjax.reload({container:"#tmpl_list_holder",timeout:2e3})
        },

        // saveSelectedItem : function (cont = false) {
        //     var attrs = __getAllAttrs($('div#froala-editor').froalaEditor('html.get'));
        //     $.post(base_url+'/settemplate', {t:$('input[name=tid]').val(), b:$('div#froala-editor').froalaEditor('html.get'), a:attrs, n: $('input[name=tname]').val()}, function (tbody) {
        //         if (!cont) {setupwizard.cancelSelectedItem();}
        //         $('input[name=tid]').val(parseInt(tbody));
        //     });
        // },
        //
        // deleteSelectedItem : function (cont = false) {
        //     $.post(base_url+'/deletetemplate', {t:$('input[name=tid]').val()}, function (tbody) {
        //         console.log('Delete id:'+$('input[name=tid]').val()+'res:', tbody);
        //         $('input[name=tid]').val(null);
        //         $.pjax.reload({container:'#tmpl_list_holder', timeout:2e3});
        //     });
        // },

        previewTemplate: function () {
            if ($('input[name=tid]').val()) {
                var link=document.createElement('a');
                document.body.appendChild(link);
                link.setAttribute('target', '_blank');
                link.href=window.location.origin+'/document?t='+$('input[name=tid]').val();
                link.click();
            }
        }
    };
}();
