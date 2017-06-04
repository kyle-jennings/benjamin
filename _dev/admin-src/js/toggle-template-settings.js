function toggleLayoutSettings($parent, thisVal) {


  var id = $parent.attr('id');

  id = id.split('-');
  id = id[id.length - 1];
  target = id.replace('_settings_section', '');
  var $targets = $("[id*='customize-control-"+target+"'");

  $.each($targets, function(k,v){

    if(v.id.indexOf('settings_active') > -1
    || v.id.indexOf('hero_callout') > -1
    || v.id.indexOf('section') > -1
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
