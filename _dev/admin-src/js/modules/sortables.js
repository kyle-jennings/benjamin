
frontpageSortables = benjaminSortable('.js--frontpage-sortables');
widgetizedSortables = benjaminSortable('.js--widgetized-sortables');
footerSortables = benjaminSortable('.js--footer-sortables');
headerSortables = benjaminSortable('.js--header-sortables');



function benjaminSortable(elm) {

  if(elm == 'undefined')
    return;
  var self = this;

  $sortableList = $(elm);
  var $groupWrapper = $sortableList.closest('.sortables');
  var siblingsName = $groupWrapper.find('.'+$sortableList.data('sortable-group'));
  var id = $sortableList.data('setting');
  var $active = $groupWrapper.find('.js--sortables-active');
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


  function save_values(id, activeComponentsStr, $field){

    wp.customize( id, function ( obj ) {
      obj.set( activeComponentsStr );
    } );

    $field.val(activeComponentsStr);
  }


}
