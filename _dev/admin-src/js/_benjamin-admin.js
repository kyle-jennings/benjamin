// 'use strict';

jQuery(document).ready(function($) {

  require('./media-library');


  if($('body.widgets-php')){
    $('.benjamin-widget-area-options').appendTo('.widgets-sortables');
  }

});

window.$ = jQuery;
