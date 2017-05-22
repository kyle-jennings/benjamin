
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
