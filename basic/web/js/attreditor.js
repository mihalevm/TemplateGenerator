var attreditor = function(){
    var base_url =  window.location.toString();

    function __newAttr(){
        if ($('input[name=aname]').val() && $('select[name=atype]').val()) {
            $.post(base_url + '/newattr', {
                n: $('input[name=aname]').val(),
                d: $('input[name=adesc]').val(),
                ty: $('select[name=atype]').val(),
                ti: $('input[name=atitle]').val(),
                te: $('input[name=atest]').val(),
            }, function (data) {
                data = JSON.parse(data);
                console.log(data.status);
                $.pjax.reload({container:"#attr_list",timeout:2e3});
            });
        }
    }

    function __updateAttr() {
        if ($('input[name=aname]').val() && $('select[name=atype]').val()) {
            $.post(base_url + '/updateattr', {
                id: $('input[name=aid]').val(),
                n:  $('input[name=aname]').val(),
                d:  $('input[name=adesc]').val(),
                ty: $('select[name=atype]').val(),
                ti: $('input[name=atitle]').val(),
                te: $('input[name=atest]').val(),
            }, function (data) {
                data = JSON.parse(data);
                console.log(data.status);
                $.pjax.reload({container:"#attr_list",timeout:2e3})
            });
        }
    }

    return {
        saveAttr : function () {
            if ($('input[name=aid]').val()){
                __updateAttr();
            } else {
                __newAttr();
            }

            return;
        },
        clearAttr : function () {
            $('input[name=aname]').val(null);
            $('input[name=adesc]').val(null);
            $('select[name=atype]').val(1);
            $('input[name=atitle]').val(null);
            $('input[name=atest]').val(null);
            $('input[name=aid]').val(null);
        },
        setActiveItem : function (obj) {
            $(obj).parent().find('.tg-attr-item-active').removeClass('tg-attr-item-active');
            $(obj).addClass('tg-attr-item-active');

            $('input[name=aname]').val($(obj).data('aname'));
            $('input[name=adesc]').val($(obj).data('adesc'));
            $('select[name=atype]').val($(obj).data('atype'));
            $('input[name=atitle]').val($(obj).data('title'));
            $('input[name=atest]').val($(obj).data('test'));
            $('input[name=aid]').val($(obj).data('aid'));

        }
    };
}();