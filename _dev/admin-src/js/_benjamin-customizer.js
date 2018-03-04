// 'use strict';


require('./modules/load-preview-url');
require('./modules/layout-settings-flag');
require('./modules/count-widgets');

window.$ = jQuery;

jQuery(document).ready(function($) {

  require('./modules/checkbox-group');
  require('./modules/sortables');

});
