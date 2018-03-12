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