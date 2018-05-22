 $(document).ready(function(){
    $('.slider').slider();
    $('.modal').modal();
    var coll = document.getElementsByClassName("collapsiblemod");
    var i;
    console.log(coll);
    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = document.getElementById('mod'+this.getAttribute('data-id'));
          content.style.display = 'block';
        if (content.style.maxHeight){
          content.style.maxHeight = null;
            setTimeout(function(){ content.style.display = 'none'; }, 200);
        } else {
          content.style.maxHeight = content.scrollHeight + "px";
        }
      });
    }
    $("ul.submenu li a").click(function(){

    });

});

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
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

function cambiarItem(item){
  $(".activo").each(function() {
      $(this).removeClass('activo');
  })
  $("#"+item).addClass('activo');
}
