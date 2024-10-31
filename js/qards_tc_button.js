(function() {
    tinymce.PluginManager.add('qards_tc_button', function( editor, url ) {
        editor.addButton('qards_tc_button', {
            text: '',
            icon: false,
            title: 'Insert qards page into this page',
            onclick: function() {
                var dialog = jQuery('<div><input type="text" placeholder="Qards page ID" id="dialogQardsPageId" value="" style="font-size: 23px; width: 100%; margin: 0;" /></div>');
                dialog.dialog({    
                    'title': 'Insert Qards Page',               
                    'dialogClass': 'wp-dialog',           
                    'modal': true,
                    'autoOpen': false, 
                    'closeOnEscape': true,      
                    'buttons': {
                        'IFrame': function() {
                            // jQuery(this).dialog('close');
                            var qardsPageId = jQuery("#dialogQardsPageId").val();
                            if (qardsPageId) {
                                editor.insertContent('[qards_iframe id="' + qardsPageId + '"]');
                            }
                            jQuery(this).remove();
                        },
                        'Inline': function() {
                            //jQuery(this).dialog('close'); 
                            var qardsPageId = jQuery("#dialogQardsPageId").val();
                            if (qardsPageId) {
                                editor.insertContent('[qards_inline id="' + qardsPageId + '"]');
                            }
                            jQuery(this).remove();
                        }
                    }
                });
                dialog.dialog('open');
            }
        });
    });
})();
