// 'use strict';

jQuery(document).ready(function($) {

  require('./video-media-library');
  require('./video-field-updated');
  require('./video-clear');

  if($('body.widgets-php')){
    $('.benjamin-widget-area-options').appendTo('.widgets-sortables');
  }

});

window.$ = jQuery;
