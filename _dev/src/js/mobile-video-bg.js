var windowWidth = window.innerWidth;

if(windowWidth > 600) {
  var $videos = document.getElementsByClassName('video-bg');


  for (var i = 0; i < $videos.length; i++) {
    var $elm = $videos[i];
    var $video = $elm.getElementsByClassName('video')[0];
    var videoFile = $video.getAttribute("data-src");
    $video.src = videoFile;

  }
}
