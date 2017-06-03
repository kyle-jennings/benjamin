// 'use strict';

jQuery(document).ready(function($) {

  require('./refresh-alert');
  // require('./save-refresh');
  require('./toggle-template-settings');
  require('./hide-footer-menu');
  require('./sortable');
  require('./frontpage-sortables');
  require('./widgetized-sortables');
  require('./footer-sortables');


  if($('body.widgets-php')){
    $('.uswds-widget-area-options').appendTo('.widgets-sortables');
  }

});

window.$ = jQuery;
