// 'use strict';

jQuery(document).ready(function($) {

  // require('./save-refresh');
  require('./refresh-alert');
  // require('./toggle-template-settings');
  require('./hide-footer-menu');
  require('./sortable');
  require('./frontpage-sortables');
  require('./widgetized-sortables');
  require('./footer-sortables');
  require('./checkbox-group');


  if($('body.widgets-php')){
    $('.benjamin-widget-area-options').appendTo('.widgets-sortables');
  }

});

window.$ = jQuery;
