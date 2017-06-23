$('body').on('click', '.js--clear-video', function(e){
  var $this = $(this);

  var $thisParent = $this.closest('.js--media-wrapper');
  var $thisField = $thisParent.find('.js--video-url');
  var $preview = $thisParent.find('.js--placeholder');
  var settingKey = $thisField.data('is-customizer') ? $thisField.data('customize-setting-link') : null;


  $thisField.val('');
  $preview.empty();


    if(settingKey ) {

      wp.customize( settingKey, function ( obj ) {
        obj.set('');
      } );
    }
});
