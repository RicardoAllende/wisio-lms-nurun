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
  content.style.maxHeight = content.scrollHeight + 60 + "px";
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

  var refs = '';
  $.each(resources[0].references_module, function(index, value) {

      refs += (index+1)+". " + value.content + '<br>';
  })
  if(resources.length > 1){
    var arrVideo = [];
    var arrPdf = [];
    var contendiv = '';
    $.each(resources, function(index, value){
      if(value.type == "video"){
        arrVideo.push(value.url);
      } else if(value.type == "pdf"){
        arrPdf.push(value.url);
      }
    });
    console.log(arrVideo.length);
    if(arrVideo.length > 0){
      contendiv += '<video width="100%" controls>';
      for(i=0;i<=arrVideo.length-1;i++){
        contendiv += '<source src="/'+arrVideo[i]+'" type="video/mp4">'
      }
      contendiv += '</video>';
    }

    $("#"+content.id+" #content").html(contendiv);


  } else {

    var contendiv = '';
    switch(String(resources[0]['type'])) {
      case 'video':
          contendiv += '<video width="100%" controls><source src="/'+resources[0]['url']+'" type="video/mp4"></video>';
        break;
      case 'pdf':

      contendiv = '<div><button id="prev">Previous</button><button id="next">Next</button>&nbsp; &nbsp;<span>Page: <span id="page_num"></span> / <span id="page_count"></span></span></div><canvas id="the-canvas"></canvas>';
      $("#"+content.id+" #content").html(contendiv);

      // If absolute URL from the remote server is provided, configure the CORS
    // header on that server.
    var url = '/'+resources[0]['url'];

    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window['pdfjs-dist/build/pdf'];

    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

    var pdfDoc = null,
      pageNum = 1,
      pageRendering = false,
      pageNumPending = null,
      scale = 0.8,
      canvas = document.getElementById('the-canvas'),
      ctx = canvas.getContext('2d');

    /**
    * Get page info from document, resize canvas accordingly, and render page.
    * @param num Page number.
    */
    function renderPage(num) {
    pageRendering = true;
    // Using promise to fetch the page
    pdfDoc.getPage(num).then(function(page) {
      var viewport = page.getViewport(scale);
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      // Render PDF page into canvas context
      var renderContext = {
        canvasContext: ctx,
        viewport: viewport
      };
      var renderTask = page.render(renderContext);

      // Wait for rendering to finish
      renderTask.promise.then(function() {
        pageRendering = false;
        if (pageNumPending !== null) {
          // New page rendering is pending
          renderPage(pageNumPending);
          pageNumPending = null;
        }
      });
    });

    // Update page counters
    document.getElementById('page_num').textContent = num;
    }

    /**
    * If another page rendering in progress, waits until the rendering is
    * finised. Otherwise, executes rendering immediately.
    */
    function queueRenderPage(num) {
    if (pageRendering) {
      pageNumPending = num;
    } else {
      renderPage(num);
    }
    }

    /**
    * Displays previous page.
    */
    function onPrevPage() {
    if (pageNum <= 1) {
      return;
    }
    pageNum--;
    queueRenderPage(pageNum);
    }
    document.getElementById('prev').addEventListener('click', onPrevPage);

    /**
    * Displays next page.
    */
    function onNextPage() {
    if (pageNum >= pdfDoc.numPages) {
      return;
    }
    pageNum++;
    queueRenderPage(pageNum);
    }
    document.getElementById('next').addEventListener('click', onNextPage);

    /**
    * Asynchronously downloads PDF.
    */
    pdfjsLib.getDocument(url).then(function(pdfDoc_) {
    pdfDoc = pdfDoc_;
    document.getElementById('page_count').textContent = pdfDoc.numPages;

    // Initial/first page rendering
    renderPage(pageNum);
    });



        break;
    }


  }

  $("#"+content.id+" #name_module").text(resources[0]['name_module']);
  $("#"+content.id+" #references").html(refs);
  openModule();

}
