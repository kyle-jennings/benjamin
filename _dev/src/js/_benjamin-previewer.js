// 'use strict';

jQuery(document).ready(function($) {

  wp.customize.preview.bind( 'widgetWidthClasses', function ( data ) {

    setTimeout(function(){ 

      var $widgets = document.querySelectorAll('.widget-area--' + data.sidebar);
      var prefix = 'usa-width-';
      var newClasses;


      $widgets.forEach(function($e,i,a){

        var classes = $e.className.split(" ").filter(function(c) {
          return c.indexOf(prefix) !== 0;
        });
        classes.push(data.className);
        classes = classes.join(" ").trim();

        $e.className = classes;
      });

    }, 1000);
    
    

  });

});

window.$ = jQuery;