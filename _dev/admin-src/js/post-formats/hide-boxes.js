
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
