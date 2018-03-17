(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
// 'use strict';

require('./post-formats/media');
require('./post-formats/hide-boxes');
require('./post-formats/status');

},{"./post-formats/hide-boxes":2,"./post-formats/media":3,"./post-formats/status":4}],2:[function(require,module,exports){

// more or less just hides and shows the various metaboxes
jQuery(document).ready(function($){

  hide_format_boxes();
  clearLink();


  if( $("#post-formats-select").length <= 0) 
    return;

  var selectedPostFormat = $("input[name='post_format']:checked").val();

  var post_formats = ['aside', 'status', 'gallery', 'image', 'link', 'quote', 'audio', 'video', 'chat'];

  // show the metabox on init
  if( $.inArray( selectedPostFormat, post_formats ) != '-1' ) {
		$('#post_formats_' + selectedPostFormat).show();
	}


  $("input[name='post_format']:radio").change(function() {
    // hide the meta boxes
		hide_format_boxes();

    // if the selected post format is in the post formats list then show the box
		if( $.inArray( $(this).val(), post_formats ) != '-1' ) {
			$('#post_formats_' + $(this).val()).show()
		}

  
  });





});


function hide_format_boxes(){
  var post_formats = ['aside', 'status', 'gallery', 'image', 'link', 'quote', 'audio', 'video', 'chat'];
  post_formats = post_formats.map( function(a){
    return '#post_formats_'+a;
  }).join(', ');

  $(post_formats).hide();
}




function clearLink() {
  $('.pfp-js-remove-link').on('click', function(e){
    e.preventDefault();
    $(this).closest('.link-box').find('input').val('');

  });
}

},{}],3:[function(require,module,exports){
jQuery(document).ready(function($){


  // when a URL is pasted in
  $('.post_format_value').on('change', function(e){
    e.preventDefault();
    var $this = $(this);
    var $metabox = $this.closest('.postbox');
    var url = $this.val();
    var format = $this.data('media');
    window['pfpAJAXMarkup'](url, format, $metabox);

  });


  // when the "remove image" link is clicked
  $('.pfp-js-remove-media').on('click', function(e){
    e.preventDefault();


    var $this = $(this);
    var $metabox = $this.closest('.postbox');

    $metabox.find('.pfp-media-holder').html('');
    $metabox.find('.post_format_url').val('');
    $metabox.find('.post_format_value').val('');
  });



  // open the media library
  $('.pfp-js-media-library').on('click', function(e){
    e.preventDefault();

    var $this = $(this);
    var format = $this.data('media');
    var $metabox = $this.closest('.postbox');
    var media = $metabox.find('.post_format_value').val();

    // if the media library is already created, open it
    if(wp.media.frames.mediaBox){
      delete wp.media.frames.mediaBox;
    }

    // initialize media library
    wp.media.frames.mediaBox = wp.media({
      title: format,
      button: { text: 'Select ' + format },
      library: { type: format },
      multiple: false
    })


    // when the media is selelected, set the values
    wp.media.frames.mediaBox.on('select', function(){
      media_attachment = wp.media.frames.mediaBox.state().get('selection').first().toJSON();

      var funcName = 'pfp' + titleCase(format) + 'Select';
      pfpMediaSelect(media_attachment, format, $metabox);

    })

    wp.media.frames.mediaBox.open();
  });

});


/**
 * set the image correctly
 * @param  {object} media_attachment the media object sent from the wp media library
 * @param  {string} format           what type of post format are we working with?
 * @param  {object} $metabox         jquery object/DOM element
 * @return {html}                  new DOM element to display the media
 */
function pfpMediaSelect(media_attachment, format, $metabox){
  var $html = pfpAJAXMarkup(media_attachment.url, format, $metabox);

  console.log( media_attachment, format, $metabox );
  $metabox.find('.post_format_value').val(media_attachment.url);

}




/**
 * AJAX the markup for the specified post format media type
 * @param  {string} url    [description]
 * @param  {string} format [description]
 *  * @param  {object} $metabox         jquery object/DOM element
 * @return {html}        [description]
 */
window.pfpAJAXMarkup = function(url, format, $metabox){

  var data = {
    action: 'benjamin_postformat_oembed',
    pfpURL: url,
    pfpType: format
  };

  jQuery.ajax({
    type: "POST",
    url: ajaxurl,
    data: data,
    complete: function(response){
      if(response.status == 200){
        console.log(response);
        var $html = response.responseText;
        if($html == ''){
          $metabox.find('.post_format_url').val('');
          $metabox.find('.post_format_value').val('');
        }
        $metabox.find('.pfp-media-holder').html( $html );

      }
    }
  });

};



/**
 * Capitzalize a string
 * @param  {string} string the text string to capitalize
 * @return {string}        the capitalized text string
 */
function titleCase(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

},{}],4:[function(require,module,exports){
$('.js--post-format-status-textarea').on('keyup', function(){
  var max = 140;
  var $this = $(this);
  var count = $this.val().length;
  var $countElm = $this.prev('.js--char-count');

  $countElm.text(count);
  if (count >= max) {
    $countElm.css('color', 'red');
  }
  else {
    $countElm.css('color', '');
  }
    
});
},{}]},{},[1]);
