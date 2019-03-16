// 'use strict';

require('./modules/install-franklin');

jQuery(document).ready(function($) {


  if($('body.widgets-php')){
    $('.benjamin-widget-area-options').appendTo('.widgets-sortables');
  }

});

window.$ = jQuery;

