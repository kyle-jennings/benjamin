(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
// 'use strict';

jQuery(document).ready(function($) {

  // require('./save-refresh');
  require('./refresh-alert');
  require('./toggle-template-settings');
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

},{"./checkbox-group":2,"./footer-sortables":3,"./frontpage-sortables":4,"./hide-footer-menu":5,"./refresh-alert":6,"./sortable":7,"./toggle-template-settings":8,"./widgetized-sortables":9}],2:[function(require,module,exports){
$('.js--checkbox-group input[type="checkbox"]').on('change', function(e){
  var $this = $(this);
  var $parent = $this.closest('.js--checkbox-group');
  var targetID = $parent.attr('id');
  var $targetField = $('.'+targetID.replace('js--', ''));
  var settingID = $parent.data('setting');
  var $siblings = $parent.find('input[type="checkbox"]:checked');
  var thisVal = $this.val();
  var checked = [];

  $siblings.each(function(idx) {

    var $thisComp = $(this);
    var component = $thisComp.val();

    checked.push(component);
  });


  save_checkbox_group_value(settingID, JSON.stringify(checked), $targetField );

});


function save_checkbox_group_value(key, componentsStr, $field){

  wp.customize( key, function ( obj ) {

    obj.set( componentsStr );
  } );

  $field.val( componentsStr );
}

},{}],3:[function(require,module,exports){
jQuery(function($) {

  if($('.js--footer-sortables').length <= 0)
    return;

  var $sortableList = $('.js--footer-sortables');
  var $groupWrapper = $sortableList.closest('.sortables');
  var siblingsName = $groupWrapper.find('.'+$sortableList.data('sortable-group'));
  var id = $sortableList.data('sortable-group').replace('_control', '_setting');
  var $active = $groupWrapper.find('.js--sortables-active');

  var $field = $groupWrapper.find('input[type="hidden"]');
  // inits the sortable and does things
  $sortableList.sortable({
    placeholder: 'ui-state-highlight',
    connectWith: siblingsName,
    change: function(e, u){

    },
  	update: function(event, ui) {
      var $this = $(this);

      var activeComponentsStr = '';

      activeComponentsStr = get_active_sortables($active);

      save_values(id, activeComponentsStr, $field)
    },
    receive: function(e){}
  });


  // when the visibility changes
  // $('.sortable__visibility select').on('change', function(e){
  //   var $this = $(this);
  //   var thisVal = $this.val();
  //   $this.closest('.sortable').addClass('save-warning');
  //   $('#submit').parent('.submit').addClass('save-warning');
  //
  //   var activeComponentsStr = get_active_sortables($active);
  //   save_values(id, activeComponentsStr, $field);
  //
  // });


  // gets the active sortables and sets their settings/positions to a string to be saved
  function get_active_sortables($active){
    var activeComponents = [];

    // loop through the active components and collect their data
    $active.find('li').each(function(idx) {
        var $thisComp = $(this);
        var component = $thisComp.attr('id');
        var label = $thisComp.text();

        $thisComp.addClass('save-warning');
        activeComponents.push({
          name: component,
          label: label
        });
    });
    // stringify the array into a string and return
    return JSON.stringify(activeComponents);
  }


  function save_values(key, activeComponentsStr, $field){

    wp.customize( key, function ( obj ) {

      obj.set( activeComponentsStr );
    } );

    $field.val(activeComponentsStr);
  }
});

},{}],4:[function(require,module,exports){
jQuery(function($) {

  if($('.js--frontpage-sortables').length <= 0)
    return;

  var $sortableList = $('.js--frontpage-sortables');
  var $groupWrapper = $sortableList.closest('.sortables');
  var siblingsName = $groupWrapper.find('.'+$sortableList.data('sortable-group'));
  var id = $sortableList.data('sortable-group').replace('_control', '_setting');
  var $active = $groupWrapper.find('.js--sortables-active');

  var $field = $groupWrapper.find('input[type="hidden"]');
  // inits the sortable and does things
  $sortableList.sortable({
    placeholder: 'ui-state-highlight',
    connectWith: siblingsName,
    change: function(e, u){

    },
  	update: function(event, ui) {
      var $this = $(this);

      var activeComponentsStr = '';

      activeComponentsStr = get_active_sortables($active);

      save_values(id, activeComponentsStr, $field)
    },
    receive: function(e){}
  });


  // when the visibility changes
  $('.sortable__visibility select').on('change', function(e){
    var $this = $(this);
    var thisVal = $this.val();
    $this.closest('.sortable').addClass('save-warning');
    $('#submit').parent('.submit').addClass('save-warning');

    var activeComponentsStr = get_active_sortables($active);
    save_values(id, activeComponentsStr, $field);

  });


  // gets the active sortables and sets their settings/positions to a string to be saved
  function get_active_sortables($active){
    var activeComponents = [];

    // loop through the active components and collect their data
    $active.find('li').each(function(idx) {
        var $thisComp = $(this);
        var component = $thisComp.attr('id');
        var label = $thisComp.text();

        $thisComp.addClass('save-warning');
        activeComponents.push({
          name: component,
          label: label
        });
    });
    // stringify the array into a string and return
    return JSON.stringify(activeComponents);
  }


  function save_values(key, activeComponentsStr, $field){

    wp.customize( key, function ( obj ) {
      obj.set( activeComponentsStr );
    } );

    $field.val(activeComponentsStr);
  }
});

},{}],5:[function(require,module,exports){

function hideFooterMenuSetting($) {
  var val = $('input[name=_customize-radio-footer_top_content_control]:checked').val();

  if(val !== 'menu') {
    $('#customize-control-footer_menu_control').fadeOut();
  }else{
    $('#customize-control-footer_menu_control').fadeIn();
  }
}


// customizer JS
if($('body.wp-customizer')){
  $('#customize-control-footer_top_content_control input').live('click', function(){
    hideFooterMenuSetting($);
  });

  hideFooterMenuSetting($);
}

},{}],6:[function(require,module,exports){
window.refreshAlert = function() {

  $('#save').addClass('alert alert--refresh').val('Save and Refresh');
}

},{}],7:[function(require,module,exports){
jQuery(function($) {

  if($('.js--sortables').length <= 0)
    return;

  var $sortableList = $('.js--sortables');
  var $groupWrapper = $sortableList.closest('.sortables');
  var siblingsName = $groupWrapper.find('.'+$sortableList.data('sortable-group'));
  var id = $sortableList.data('sortable-group').replace('_control', '_setting');
  var $active = $groupWrapper.find('.js--sortable-active');

  var $field = $groupWrapper.find('input[type="hidden"]');


  // inits the sortable and does things
  $sortableList.sortable({
    placeholder: 'ui-state-highlight',
    connectWith: siblingsName,
  	update: function(event, ui) {
      var $this = $(this);

      var activeComponentsStr = '';

      activeComponentsStr = get_active_sortables($active);

      save_values(id, activeComponentsStr, $field)
    },
    receive: function(e){}
  });


  // when the visibility changes
  $('.sortable__visibility select').on('change', function(e){
    var $this = $(this);
    var thisVal = $this.val();
    $this.closest('.sortable').addClass('save-warning');
    $('#submit').parent('.submit').addClass('save-warning');

    var activeComponentsStr = get_active_sortables($active);
    save_values(id, activeComponentsStr, $field);

  });


  // gets the active sortables and sets their settings/positions to a string to be saved
  function get_active_sortables($active){
    var activeComponents = [];

    // loop through the active components and collect their data
    $active.find('li').each(function(idx) {
        var $thisComp = $(this);
        var component = $thisComp.attr('id');
        var label = $thisComp.text();

        $thisComp.addClass('save-warning');
        activeComponents.push({
          name: component,
          label: label
        });
    });
    // stringify the array into a string and return
    return JSON.stringify(activeComponents);
  }


  function save_values(key, activeComponentsStr, $field){


    wp.customize( key, function ( obj ) {
      obj.set( activeComponentsStr );
    } );

    $field.val(activeComponentsStr);
  }
});

},{}],8:[function(require,module,exports){
function toggleLayoutSettings($parent, thisVal) {


  var id = $parent.attr('id');

  id = id.split('-');
  id = id[id.length - 1];
  target = id.replace('_settings_section', '');
  var $targets = $("[id*='customize-control-"+target+"'");

  $.each($targets, function(k,v){

    if(v.id.indexOf('settings_active') > -1
    || v.id.indexOf('hero_callout') > -1
    || v.id.indexOf('sortable') > -1
    )
      return;

    if(thisVal == 'yes'){
      $(v).fadeIn();
    }else{
      $(v).fadeOut();

    }

  });

}

// toggle the layout settings
if($('body.wp-customizer')){

  // when the setting is changed
  $('.js--toggle-layout-options input[type="radio"]').live('change', function(e){
    var $this = $(this);
    var $parent = $this.closest('.control-section');
    var thisVal = $this.val();

    toggleLayoutSettings($parent, thisVal);
    refreshAlert();

  });

  // when the page loads
  var $activeToggles = $('.js--toggle-layout-options');

  $activeToggles.each(function(k, v){
    var $this = $(this);
    var $parent = $this.closest('.control-section');
    var $radio = $this.find('input[type="radio"]:checked');
    var thisVal = $radio.val();
    toggleLayoutSettings($parent, thisVal);



  });

}

},{}],9:[function(require,module,exports){
jQuery(function($) {

  if($('.js--widgetized-sortables').length <= 0)
    return;

  var $sortableList = $('.js--widgetized-sortables');
  var $groupWrapper = $sortableList.closest('.sortables');
  var siblingsName = $groupWrapper.find('.'+$sortableList.data('sortable-group'));
  var id = $sortableList.data('sortable-group').replace('_control', '_setting');
  var $active = $groupWrapper.find('.js--sortables-active');

  var $field = $groupWrapper.find('input[type="hidden"]');
  // inits the sortable and does things
  $sortableList.sortable({
    placeholder: 'ui-state-highlight',
    connectWith: siblingsName,
    change: function(e, u){

    },
  	update: function(event, ui) {
      var $this = $(this);

      var activeComponentsStr = '';

      activeComponentsStr = get_active_sortables($active);

      save_values(id, activeComponentsStr, $field)
    },
    receive: function(e){}
  });


  // when the visibility changes
  $('.sortable__visibility select').on('change', function(e){
    var $this = $(this);
    var thisVal = $this.val();
    $this.closest('.sortable').addClass('save-warning');
    $('#submit').parent('.submit').addClass('save-warning');

    var activeComponentsStr = get_active_sortables($active);
    save_values(id, activeComponentsStr, $field);

  });


  // gets the active sortables and sets their settings/positions to a string to be saved
  function get_active_sortables($active){
    var activeComponents = [];

    // loop through the active components and collect their data
    $active.find('li').each(function(idx) {
        var $thisComp = $(this);
        var component = $thisComp.attr('id');
        var label = $thisComp.text();

        $thisComp.addClass('save-warning');
        activeComponents.push({
          name: component,
          label: label
        });
    });
    // stringify the array into a string and return
    return JSON.stringify(activeComponents);
  }


  function save_values(key, activeComponentsStr, $field){


    wp.customize( key, function ( obj ) {
      obj.set( activeComponentsStr );
    } );

    $field.val(activeComponentsStr);
  }
});

},{}]},{},[1]);
