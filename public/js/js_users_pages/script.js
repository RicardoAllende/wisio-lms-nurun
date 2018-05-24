 $(document).ready(function(){

    $('.modal').modal();


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

  if(slides > 0){
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

function cambiarItem(item){
  $(".activo").each(function() {
      $(this).removeClass('activo');
  })
  $("#"+item).addClass('activo');
}

var coll = document.getElementsByClassName("collapsiblemod");
var i;
var content = null;
var modActive = null;
var blockViewModule = false;
var idModule = null;
for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    if(!blockViewModule){
      blockViewModule = true;
      modActive = this;
      modActive.classList.toggle("active");
      content = document.getElementById('mod'+this.getAttribute('data-id'));

      idModule = this.getAttribute('data-module');
      getResourcesModules(idModule);

    }
  });
}

function openModule(){
  content.style.display = 'block';
  content.style.maxHeight = content.scrollHeight + "px";
}

function closeModule(){
  console.log("close module");
  modActive.classList.toggle("active");
  content.style.maxHeight = null;
  setTimeout(function(){ content.style.display = 'none';blockViewModule = false;}, 200);

}

function getResourcesModules(idMod){
  $.ajax({
  type: 'post',
  url: window.location+'/module/get_resources',
  data: {
    idModule: idMod,
    _token: $('meta[name="csrf-token"]').attr('content')
  },
  success: function (resources) {
      //console.log("exito");
      printResources(resources)
      //console.log(resources);
  },
  error: function(request, error){
    console.log(error);
  }

});
}

function printResources(resources){
  if(resources.length > 1){

  } else {
    var refs = '';
    var content = '';
    $("#"+content.id+" #name_module").html(resources[0]['name_module']);

    switch(String(resources[0]['type'])) {
      case 'video':
          content += '<video width="100%" controls><source src="'+resources[0]['url']+'" type="video/mp4"></video>';
        break;
      case 'pdf':

        break;
    }
    console.log(content);
    $("#"+content.id+" #content").html(content);
    $.each(resources[0].references_module, function(index, value) {

        refs += (index+1)+". " + value.content + '<br>';
    })
    $("#"+content.id+" #references").html(refs);

    openModule();

  }


}
