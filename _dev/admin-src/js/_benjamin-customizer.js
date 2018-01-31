// 'use strict';

jQuery(document).ready(function($) {

  require('./checkbox-group');
  require('./load-preview-url');
  require('./refresh-alert');

  require('./sortables');


  wp.customize.bind( 'change', function ( setting ) {
    wp.customize.previewer.send('widgetThing', 'widgetThing');
  });
});

window.$ = jQuery;
