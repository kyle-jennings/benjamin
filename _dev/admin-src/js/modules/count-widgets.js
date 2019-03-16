wp.customize.bind('ready', function() {


  var sidebars = [
    'banner-widget-area',
    'widgetized-widget-area-1',
    'widgetized-widget-area-2',
    'widgetized-widget-area-3',
    'frontpage-widget-area-1',
    'frontpage-widget-area-2',
    'frontpage-widget-area-3',
    'footer-widget-area-1',
    'footer-widget-area-2',
  ];

  sidebars.forEach(function(e,i,a){
    
    var sidebar = 'sidebars_widgets[' + e + ']';
    
    if( wp.customize( sidebar ) == null )
      return;

    wp.customize( sidebar, function( sidebarSetting ) {
      sidebarSetting.bind( function( newWidgetIds, oldWidgetIds ) {

        var count = wp.customize( sidebar ).get().length;
        
        getWidgetSize(count, e );

      });
    } );

  });

});


function getWidgetSize(count, sidebar) {
  
  if(count == null)
    return;



  var data = {
    "action": "benjamin_calculate_widget_width",
    "data": count
  };


  $.ajax({
    type: 'post',
    url: ajaxurl,
    data: data,

    complete: function(response){
      var output = response.responseText;
      sendWidthToPreviewer(output, sidebar);
    }
  });

}


function sendWidthToPreviewer(className, sidebar) {
  wp.customize.previewer.send('widgetWidthClasses', {className: className, sidebar: sidebar} );
}