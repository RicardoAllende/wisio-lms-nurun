
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function plusSlidesE(n){
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function currentSlideE(n){
  showSlidesE(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");

  if(slides.length > 0){
    if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" activeFunciona", "");
      }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " activeFunciona";
  }


}

function showSlidesE(n){
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("circle-dot");
  console.log("Se encontraron " + dots.length);
  if(slides.length > 0){
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
    let selector = '.dot' + n;
    $(selector).removeClass( "circle-not-selected" );
    $(selector).addClass( "circle-selected" );
  }

}
