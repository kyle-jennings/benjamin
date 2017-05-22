
$('body').on('click', '.alert--refresh', function(event) {
  console.log('boom!');

  setTimeout(
  function() {
    console.log('refresh!');
    // window.wp.customize.previewer.refresh();
  }, 4000);
});
