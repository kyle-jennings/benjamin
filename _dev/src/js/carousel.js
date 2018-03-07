(function(){
  
  var playing = true;
  var slides = document.querySelectorAll('.js--carousel .item');
  var currentSlide = 0;
  var slideInterval = setInterval(nextSlide, 6000);

  function nextSlide() {
    goToSlide(currentSlide + 1);
  }

  function previousSlide() {
    goToSlide(currentSlide - 1);
  }

  function goToSlide(n) {
    slides[currentSlide].className = 'item';
    currentSlide = (n + slides.length) % slides.length;
    slides[currentSlide].className = 'item active';
  }
  
  function pauseSlideshow() {
    playing = false;
    clearInterval(slideInterval);
  }

  function playSlideshow() {

      playing = true;
      slideInterval = setInterval(nextSlide,2000);
  }

  document.querySelector('.js--next').onclick = function(){
    pauseSlideshow();
    nextSlide();
  };
  document.querySelector('.js--prev').onclick = function(){
    pauseSlideshow();
    previousSlide();
  };

}());