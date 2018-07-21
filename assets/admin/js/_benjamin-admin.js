(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
// 'use strict';

require('./modules/install-franklin');

jQuery(document).ready(function($) {


  if($('body.widgets-php')){
    $('.benjamin-widget-area-options').appendTo('.widgets-sortables');
  }

});

window.$ = jQuery;


},{"./modules/install-franklin":2}],2:[function(require,module,exports){
// wp_admin/js/updates.js
// line 206 is the wp.updates.ajax function(){}
// '{uri to wp-admin directory}/update.php?action=install-plugin&plugin=franklin&_wpnonce={wpnonce}'


/**
 * Sends an Ajax request to the server to install a plugin.
 *
 * @since 4.6.0
 * @param {string} [action] [which ajax action to perform]
 * 
 * @param {object}                args         Arguments.
 * @param {string}                args.slug    Plugin identifier in the WordPress.org Plugin repository.
 * @param {installPluginSuccess=} args.success Optional. Success callback. Default: wp.updates.installPluginSuccess
 * @param {installPluginError=}   args.error   Optional. Error callback. Default: wp.updates.installPluginError
 * @return {$.promise} A jQuery promise that represents the request,
 *                     decorated with an abort() method.
 */
// wp.updates.ajax( 'install-plugin', args );


// How the install is triggered from the "add new plugin" screen
// slug is just the URL to the plugin in the repos
// wp.updates.installPlugin( {
//     slug: $button.data( 'slug' )
// } );
// this is missing the success/error callbacks, we need to add these to change 
// the install button to "activate" or whatever
// 
 
// To activate the plugin, replace the link url with:
// plugins.php file directory = 'https://benjamin.loc/wordpress/wp-admin
//'{uri to wp-admin directory}/plugins.php?action=activate&plugin=franklin%2Ffranklin.php&plugin_status=all&paged=1&s&_wpnonce={wpnonce}'
//

window.franklinPlugin = {

  success: function(response){
    var $installFranklin = document.querySelector('.js--install-activate-franklin');
    if(response.activateUrl){
      setTimeout( function() {
        $installFranklin.setAttribute('href', response.activateUrl);
        $installFranklin.classList.remove('disabled');
        $installFranklin.innerText = wp.updates.l10n.activatePlugin;
      }, 2000);
    }
  },
  error: function(response){
    var $installFranklin = document.querySelector('.js--install-activate-franklin');
    $installFranklin.classList.remove('disabled');
    $installFranklin.innerText = wp.updates.l10n.installNow;

  },


  installButtonEvent: function(){
    var $installFranklin = document.querySelector('.js--install-activate-franklin');
    if(!$installFranklin) {
      return;
    }

    $installFranklin.addEventListener('click', function(e){
      var url = e.target.getAttribute('href');
      var text = e.target.innerText;
      
      if(this.classList.contains('disabled')) {
        e.preventDefault();
        return;
      }

      if(text.indexOf('Install') > -1 && url.indexOf('action=install-plugin') > -1) {
        var args = {
          slug: 'franklin',
          success: franklinPlugin.success
        };
        e.preventDefault();
        this.classList.add('disabled');
        this.innerText = wp.updates.l10n.installing;
        wp.updates.ajax( 'install-plugin', args );

      } else if (text.indexOf('Activate') > -1 && url.indexOf('action=activate') > -1) {
        console.log('activate plugin', e.originalEvent, 'bom');
      }
    });
      
  },

  saveDismissValue: function(){

    var data = {
      action: 'benjamin_dismiss_franklin_notice'
    };

    jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: data
    });
  },

  dismissButtonEvent: function(){


    var $franklinNoticeDismiss = document.querySelectorAll('.js--dismiss-franklin-notice');
    if($franklinNoticeDismiss.length <= 0) {
      return false;
    }
    $franklinNoticeDismiss.forEach(function($elm,k){

      $elm.addEventListener('click', function(e){
        e.preventDefault();
        var $notice  = this.closest('.franklin-notice');
        this.closest('.franklin-notice').parentNode.removeChild($notice);

        franklinPlugin.saveDismissValue();
      });

    });
    
  },

  init: function() {

  }
};

franklinPlugin.installButtonEvent();
franklinPlugin.dismissButtonEvent();
},{}]},{},[1]);
