(function() {
     tinymce.PluginManager.add( 'shortcode_drop', function( editor, url ) {
          
          theme_shortcodesUrl = url;
          // On remonte d'un repertoire
          theme_url = theme_shortcodesUrl.substring(0, theme_shortcodesUrl.length-2);
          
          var buttonstyle = "background:url('" + theme_url + "images/favicon.ico') no-repeat 5px 2px";
          
          editor.addButton( 'theme_shortcode_button', {
               type: 'menubutton',
               style: buttonstyle,
               tooltip: 'Shortcodes',
               menu: [
                    {    text: 'Tiret', 
                         menu: [
                              {
                                   text: 'Tiret',
                                   onclick: function() {editor.insertContent('[theme_tiret titre="TITRE"]—[/theme_tiret]');}
                              }
                         ],
                         
                    },                             
                    {    text: 'Lien',
                         menu: [
                              {
                                   text: 'Lien',
                                   onclick: function() {editor.insertContent('[theme_lien lien="LIEN_PAGE_DESTINATION"]TEXTE_APPEL_ACTION[/theme_lien]');}
                              },
                         ],                         
                    },                   
                    {    text: 'Bloc de question / réponse', 
                         menu: [
                              {    text: 'Bloc de question / réponse',
                                   onclick: function() {editor.insertContent('[theme_question titre="TITRE DE LA QUESTION"]TEXTE[/theme_question]');}
                              },
                         ],
                    },
               ]
          } );          
     } );
} )();