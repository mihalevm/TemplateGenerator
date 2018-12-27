var documentGen = function(){
    var base_url =  window.location.origin+window.location.pathname;
    var DKey = null;

    return {
        saveDocument : function () {
            var masterData = [];

            var values = $('#docMasterHolder').find('input');
            $(values).each(function (it) {
                masterData[it] = {name:$(values[it]).attr('name'), val:$(values[it]).val()};
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