$('body').on('change','.js--video-url', function(e){

  var $this = $(this);
  var url = $this.val();
  var $thisParent = $this.closest('.js--media-wrapper');
  var $preview = $thisParent.find('.js--placeholder');
  var settingKey = $this.data('is-customizer') ? $this.data('customize-setting-link') : null;


  var data = {
    "action": "benjamin_video_shortcode",
    "data": url
  };
  $.ajax({
    type: 'post',
    url: ajaxurl,
    data: data,
    complete: function(response){
      var output = response.responseText;
      // console.log(output);
      $preview.html( output );
    }
  });


  if(settingKey && url ) {

    wp.customize( settingKey, function ( obj ) {
      obj.set( url );
    } );
  }

});
