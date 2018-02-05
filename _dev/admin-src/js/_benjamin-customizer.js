// 'use strict';


require('./load-preview-url');
require('./layout-settings-flag');
require('./count-widgets');

window.$ = jQuery;

jQuery(document).ready(function($) {

  require('./checkbox-group');
  require('./sortables');
  // require('./refresh-alert');

});



//  js/fe-loader.js
// jQuery(window).on("load", function() {
 
//     monitor_events('wp.customize');
//     monitor_events('wp.customize.previewer');
//     monitor_events('wp.customize.control');
//     monitor_events('wp.customize.section');
//     monitor_events('wp.customize.panel');
//     monitor_events('wp.customize.state');
 
//     function monitor_events( object_path ) {
//         var p = eval(object_path);
//         var k = _.keys(p.topics);
//         console.log( object_path + " has events ", k);
//         _.each(k, function(a) {
//             p.bind(a, function() {
//                 console.log( object_path + ' event ' + a, arguments );
//             });
//         });
//     }
// });


