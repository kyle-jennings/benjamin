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
