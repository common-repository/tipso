jQuery(document).ready(function(){
    tinymce.PluginManager.add('tipso_mce_button', function( editor, url ) {
        editor.addButton('tipso_mce_button', {
            text: false,
            icon: 'icon dashicons-testimonial',
            tooltip: 'Insert Tipso Tooltip',
            onclick: function() { console.log(url);
                editor.windowManager.open( {
                    title: 'Insert Tipso Tooltip Shortcode',
                    body: [                     
                        {
                            type: 'textbox',
                            name: 'tipsoTitle',
                            label: 'Tipso Tooltip Title'                            
                        },                   
                        {
                            type: 'textbox',
                            name: 'tipsoContent',
                            label: 'Tipso Tooltip Content',                            
                            multiline: true,
                            minWidth: 300,
                            minHeight: 50
                        }
                    ],
                    onsubmit: function( e ) {
                        
                        if( e.data.tipsoContent === '' || e.data.tipsoTitle === '' ) {                            
                     
                            editor.windowManager.alert('Please fill in all fields in a popup.');    
                     
                            return false;
                        }
                        var filterQuotes = e.data.tipsoContent.replace(/"/g, "'");
                        
                        editor.insertContent( '[tipso tip="' + e.data.tipsoContent + '"]' + e.data.tipsoTitle +'[/tipso]' );
                    }
                });
            }
        });
    });
});