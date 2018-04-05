
function gallery_box(){

  var $removeGallery = document.querySelector('.gallery_remove');
  $removeGallery.addEventListener('click', function(event){
      event.preventDefault();

      var $this = event.target;
      var $metabox = $this.closest('.postbox');
      $metabox.querySelector('.post_format_value').value = '';
      $metabox.querySelector('.pfp-shortcode-holder').innerHTML = '';
  }, false);

  // open the media library
  var $addGallery = document.querySelector('#post_format_gallery_add');
  $addGallery.addEventListener('click', function(event){
    event.preventDefault();
    var $this = event.target;
    var $metabox = $this.closest('.postbox');
    gallery_media($metabox);
  });
}


function gallery_media($metabox) {

  var images = $metabox.querySelector('.post_format_value').value;
  images = images.split(',');
  
  // if the gallery has already been initialized then just reopen it
  if(wp.media.frames.galleryBox){
    // delete wp.media.frames.galleryBox;
    wp.media.frames.galleryBox.open();
    return;
  }

  // initialize media library in gallery mode
  wp.media.frames.galleryBox = wp.media({
    title: 'Gallery',
    library: { type: 'image' },
    multiple: true,
    toolbar: 'main-gallery',
    state: 'gallery-library',
    frame: 'post'
  });

  // precheck images already in teh gallery
  wp.media.frames.galleryBox.on('open', function(){
    var selection = wp.media.frames.galleryBox.state().get('selection');
    images.forEach(function(image) {
      attachment = wp.media.attachment(image);
      attachment.fetch();
      selection.add( attachment ? [ attachment ] : [] );
    });
  });

  // when the images have been checked and the selected button is pressed..
  wp.media.frames.galleryBox.on('update', function(){
    selection = wp.media.frames.galleryBox.state().get('library');
    var str = '';
    var image_ids = [];
    selection.map( function( image ) {
      image_ids.push( image.id );
    });


    str = image_ids.join(',')
    $metabox.querySelector('.post_format_value').value = str;

    benjamin_ajax_shortcode('[gallery link="none" ids="' + str + '"]', $metabox)
  });

  // open the initialized media library
  wp.media.frames.galleryBox.open();
}


function benjamin_ajax_shortcode(str,  $metabox){

  var data = {
    action: 'benjamin_postformat_shortcode',
    pfpSTR: str
  };

  jQuery.ajax({
    type: "POST",
    url: ajaxurl,
    data: data,
    complete: function(response){
      if(response.status == 200){

        var $html = response.responseText;
        if($html == ''){
          $metabox.querySelector('.post_format_value').value = '';
        }else{
          $metabox.querySelector('.pfp-shortcode-holder').innerHTML = $html;
        }

      }
    }
  });

}



gallery_box();
