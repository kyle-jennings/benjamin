// 'use strict';

jQuery(document).ready(function($) {

  require('./checkbox-group');
  require('./footer-sortables');
  require('./frontpage-sortables');
  require('./load-preview-url');
  require('./refresh-alert');
  require('./sortable');
  require('./widgetized-sortables');


  if($('body.widgets-php')){
    $('.benjamin-widget-area-options').appendTo('.widgets-sortables');
  }

});

window.$ = jQuery;
