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
    };
}();