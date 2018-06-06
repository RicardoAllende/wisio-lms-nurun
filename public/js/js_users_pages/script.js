$(".button-collapse").sideNav({
  edge: 'left',
  draggable: true,
  onOpen: function(){
    $('#btnMenu').html('<i class="material-icons">close</i>');
  },
  onClose: function(){
    $('#btnMenu').html('<i class="material-icons">menu</i>');
  },

});

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function plusSlidesE(n){
  showSlidesE(slideIndex += n);
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
    let selector = '#dot' + n;
    $(selector).removeClass( "circle-not-selected" );
    $(selector).addClass( "circle-selected" );
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
var videoPlaying = null;
var idModule = null;
var isMob = false;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    if(!blockViewModule){
      blockViewModule = true;
      modActive = this;
      modActive.classList.toggle("activeMod");

      console.log(screen.width+" "+window.innerWidth);

      if(jQuery.browser.mobile || screen.width <= 992 || window.innerWidth <= 992){
          isMob = true;
          content = document.getElementById('modalMod');


      } else {

        content = document.getElementById('mod'+this.getAttribute('data-id'));
      }

      if(this.getAttribute('data-module')){
        idModule = this.getAttribute('data-module');
        getResourcesModules(idModule);
      } else if(this.getAttribute('data-eval')){
        idEval = this.getAttribute('data-eval');
        getQuestionsEval(idEval);
        openModule();
      }


    }
  });
}

function openModule(){

  if(isMob){
    $('#modalMod').modal('open');
  } else {
    content.style.display = 'block';
    setTimeout(function(){ content.style.maxHeight = content.scrollHeight + 60 + "px";}, 500);
  }

  //content.style.maxHeight = content.scrollHeight + 60 + "px";
}

function closeModule(){

  sendDataLrs();
  sendStatus('visto');
  modActive.classList.toggle("activeMod");
  if(isMob){
    $('#modalMod').modal('close');
    blockViewModule = false;
    $("#"+content.id+" #name_module").html('');
    $("#"+content.id+" #content").html('');
  } else {
    content.style.maxHeight = null;
    setTimeout(function(){ content.style.display = 'none';blockViewModule = false;}, 200);
    $("#"+content.id+" #content").html('');
  }

}

function getResourcesModules(idMod){
  idModule = idMod;
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

function getQuestionsEval(idEval){
  var formUrl = urlDrawForm + '/' + idEval;
  $.ajax({
    url: formUrl,
    method: 'get',
    success: function(result){
        $("#" + content.id + " #content").html(result);
    },
    error: function(error){
      $("#" + content.id + " #content").html(error);
    }
  });
}

function printResources(resources){

  if(resources.length > 0){
    var refs = '';
    var contendiv = '';
    $.each(resources[0].references_module, function(index, value) {

        refs += (index+1)+". " + value.content + '<br>';
    })

    if(resources.length > 1){
      var arrVideo = [];
      var arrPdf = [];

      $.each(resources, function(index, value){
        if(value.type == "video"){
          arrVideo.push(value.url);
        } else if(value.type == "pdf"){
          arrPdf.push(value.url);
        }
      });

      if(arrVideo.length > 0){
        contendiv += '<video width="100%" controls id="video">';
        contendiv += '<source src="/'+arrVideo[0]+'" type="video/mp4">'
        contendiv += '</video>';
      }

      var contVid = 0;

      $("#"+content.id+" #content").html(contendiv);
      var vide = document.getElementById('video');
      vide.onended = function() {

          contVid++;
          if(arrVideo[contVid] != undefined){
            vide.src = '/'+arrVideo[contVid];
            vide.play();
          } else {
            console.log('video concluido');
          }

      };
      vide.onplay = function() {
        videoPlaying = vide;
      };
      vide.onpause = function() {

      }

    } else {

      var contendiv = '';
      switch(String(resources[0]['type'])) {
        case 'video':
            contendiv += '<video width="100%" controls><source src="/'+resources[0]['url']+'" type="video/mp4"></video>';
            $("#"+content.id+" #content").html(contendiv);
            vide.onended = function() {
              console.log('video concluido');
            };
            vide.onplay = function() {
              videoPlaying = vide;
            };
            vide.onpause = function() {

            }
          break;
        case 'pdf':

            contendiv = '<div><button id="prev">Previous</button><button id="next">Next</button>&nbsp; &nbsp;<span>Page: <span id="page_num"></span> / <span id="page_count"></span></span></div><canvas  width="100%" id="the-canvas"></canvas>';
            $("#"+content.id+" #content").html(contendiv);
            printPdfplayer('/'+resources[0]['url']);

          break;
      }


    }

    //console.log(refs);
    $("#"+content.id+" #name_module").text(resources[0]['name_module']);
    $("#"+content.id+" #references").html(refs);
    openModule();
  } else {
    $("#"+content.id+" #references").html("Este módulo aún no tiene recursos disponibles, contacte a su administrador.");
    openModule();
  }



}

function printPdfplayer(url){
  var pdfjsLib = window['pdfjs-dist/build/pdf'];

  // The workerSrc property shall be specified.
  pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

  var pdfDoc = null,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = 1,
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
}

function sendDataLrs(){
  if(videoPlaying != null){
      console.log(videoPlaying.currentSrc+"  "+videoPlaying.currentTime);
  } else {

  }

}

function sendStatus(status_){
    var url_ = window.location.hostname +'/save_progress_module';

    $.ajax({
    type: 'post',
    url: url_,
    data: {
      module_id: idModule,
      status:status_,
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function (result) {
        console.log(result);
    },
    error: function(request, error){
      console.log(error);
    }

  });
}
