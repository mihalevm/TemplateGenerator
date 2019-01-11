var templates = function(){
    var base_url =  window.location.toString();
    var new_img = null;

    function __getAllAttrs(str) {
        var re = /\{(\w+)\}/g;
        var ret = '';
        var m;
        do {m = re.exec(str); if (m) { ret = ret+m[1]+';'; } } while (m);

        ret = ret.slice(0, -1);

        return ret;
    }

    return {
        setActiveItem : function (obj) {
            $(obj).parent().find('.tg-attr-item-active').removeClass('tg-attr-item-active');
            $(obj).addClass('tg-attr-item-active');
            $('input[name=tid]').val($(obj).data('tid'));
            $('input[name=tname]').val($(obj).data('tname'));
        },
        editSelectedItem : function (add) {

            if ($('input[name=tid]').val() || add) {
                $.post(base_url + '/getattr', {}, function (attr) {
                    $.FroalaEditor.DefineIcon('varadd', {NAME: 'cog'});
                    $.FroalaEditor.RegisterCommand('varadd', {
                        title: 'Добавить переменную',
                        type: 'dropdown',
                        focus: false,
                        undo: false,
                        refreshAfterCallback: true,
                        options: attr,
                        callback: function (cmd, val) {
                            this.html.insert('{' + val + '}');
                        },
                    });

                    $.post(base_url + '/gettemplate', {t: $('input[name=tid]').val()}, function (tbody) {
                        $('div#froala-editor').html(tbody);
                        $('div#froala-editor').froalaEditor({
                            heightMin: 710,
                            heightMax: 710,
                            toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'inlineClass', 'clearFormatting', '|', 'emoticons', 'fontAwesome', 'specialCharacters', '-', 'paragraphFormat', 'lineHeight', 'paragraphStyle', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '|', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '-', 'insertHR', 'selectAll', 'getPDF', 'print', 'help', 'html', 'fullscreen', '|', 'undo', 'redo', '|', 'varadd'],
                            imageManagerLoadURL: base_url + '/imagegallery',
                        });

                        $('div#froala-editor').on('froalaEditor.image.loaded', function (e, editor, $img) {
                            new_img = $img[0];
                        });

                        $('div#froala-editor').on('froalaEditor.image.beforeUpload', function (e, editor, $img) {
                                console.log('froalaEditor.image.beforeUpload');
                                var fd = new FormData();
                                fd.append('data', $img[0]);
                                jQuery.ajax({
                                    url: base_url + '/uploadimage',
                                    data: fd,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method: 'POST',
                                    success: function(src){
                                        new_img.src = src;
                                    }
                                });
                        });

                        $('div#editor-holder').show();
                        $('div#tmpl_list_holder').hide();
                        $('.breadcrumb').append('<li>' + $('input[name=tname]').val() + '</li>');
                    });
                    // console.log(attr);
                });

                if (add) {
                    $('input[name=tid]').val(null);
                    $('input[name=tname]').val('Новый шаблон');
                }
            }
        },
        cancelSelectedItem : function () {
            $('div#editor-holder').hide();
            $('div#froala-editor').froalaEditor('destroy');
            $('div#froala-editor').html('');
            $('div#tmpl_list_holder').show();
            $('.breadcrumb li:last').remove();
            $.pjax.reload({container:'#tmpl_list_holder', timeout:2e3});
        },
        saveSelectedItem : function (cont = false) {
            var attrs = __getAllAttrs($('div#froala-editor').froalaEditor('html.get'));
            $.post(base_url+'/settemplate', {t:$('input[name=tid]').val(), b:$('div#froala-editor').froalaEditor('html.get'), a:attrs, n: $('input[name=tname]').val()}, function (tbody) {
                if (!cont) {templates.cancelSelectedItem();}
                if (parseInt(tbody) > 0){
                    $('input[name=tid]').val(parseInt(tbody));
                }
            });
        },
        deleteSelectedItem : function (cont = false) {
            $.post(base_url+'/deletetemplate', {t:$('input[name=tid]').val()}, function (tbody) {
                console.log('Delete id:'+$('input[name=tid]').val()+'res:', tbody);
                $('input[name=tid]').val(null);
                $.pjax.reload({container:'#tmpl_list_holder', timeout:2e3});
            });
        },
        previewTemplate: function () {
            if ($('input[name=tid]').val()) {
                var link=document.createElement('a');
                document.body.appendChild(link);
                link.setAttribute('target', '_blank');
                link.href=base_url+'/tmplpreview?t='+$('input[name=tid]').val();
                link.click();
            }
        }

    };
}();
