var doclist = function(){
    var base_url =  window.location.origin;

    return {
        preview : function (id) {
            if (id) {
                window.open(base_url + '/document/previewdocument?k=' + id, '_blank');
                win.focus();
            }
            return;
        },
        delete : function (id) {
            $.post(
                base_url+'/doclist/delete',
                {d:id},
                function () {
                    $.pjax.reload({container:'#doc_list',timeout:2e3});
                }
            );
        }
    };
}();