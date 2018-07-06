/* Cambia el boton de menu al abrirse*/

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

/*Cambia el tamaño de fuente */
var donde = $('body');
  var sizeFuenteOriginal = donde.css('font-size');
  var contUp = 0;
  var contDown = 0;

  // Resetear Font Size
  $(".resetearFont").click(function(){
  donde.css('font-size', sizeFuenteOriginal);
  });

  // Aumentar Font Size
  $("#font-up,#font-upMob").click(function(){
    contUp++;
  	var sizeFuenteActual = donde.css('font-size');
 	var sizeFuenteActualNum = parseFloat(sizeFuenteActual, 10);
    var sizeFuenteNuevo = sizeFuenteActualNum*1.2;
    if(contUp < 4){
      donde.css('font-size', sizeFuenteNuevo);
    }

	return false;
  });

  // Disminuir Font Size
  $("#font-down,#font-downMob").click(function(){
    contDown++;
  	var sizeFuenteActual = donde.css('font-size');
 	var sizeFuenteActualNum = parseFloat(sizeFuenteActual, 10);
    var sizeFuenteNuevo = sizeFuenteActualNum*0.8;
    if(contDown < 4){
      donde.css('font-size', sizeFuenteNuevo);
    }

	return false;
  });

/*funciones para el footer siempre abajo*/
checkfooter();

$(window).resize(function(){
    checkfooter();
});

function checkfooter(){
  if($(".contenido").height() < ( $(window).height() - $('footer').height())) {
    console.log( ( $(window).height() - $('footer').height()) - $(".contenido").height() );
    $(".contenido").height( $(".contenido").height() + (( $(window).height() - $('footer').height()) - $(".contenido").height()) );
  }
}


/*funciones para presentar los slides de como funciona y evaluaciones*/
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
  //console.log("Se encontraron " + dots.length);
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

/*Funciones para mostrar el contenido de los modulos */

var coll = document.getElementsByClassName("collapsiblemod");
var i;
var content = null;
var modActive = null;
var blockViewModule = false;
var videoPlaying = null;
var idModuleGlobal = null;
var isMob = false;
var isEval = false;
var stat = false;
var hasFEvaluation = false;
var idFEvaluation = 0;

for (i = 0; i < coll.length; i++) {
  if(coll[i].getAttribute('data-disabled')){
    // Módulo deshabilitado, no tendrá funcionalidad
  }else{
    coll[i].addEventListener("click", function() {
        //console.log(isEnrolled);
      if(isEnrolled){
        if(!blockViewModule){
          blockViewModule = true;
          modActive = this;
          modActive.classList.toggle("activeMod");

          if(jQuery.browser.mobile || screen.width <= 992 || window.innerWidth <= 992){
            isMob = true;
            content = document.getElementById('modalMod');
          } else {
            content = document.getElementById('mod'+this.getAttribute('data-id'));
          }

          if(this.getAttribute('data-final')){
            if(this.getAttribute('data-final') == '1'){
              hasFEvaluation = true;
              idFEvaluation = this.getAttribute('data-final-i');
              nextUrl = urlFinal.replace('*', idFEvaluation);
            }
          }

          if(this.getAttribute('data-module')){
            idModuleGlobal = this.getAttribute('data-module');
            if(this.getAttribute('data-eva') == '1'){
              // alert('Con evaluación diagnóstica');
              this.setAttribute('data-eva', '0');
              // this.attr('data-eva', '0');
              getEvDiag(this.getAttribute('data-evi'));
            } else {
              // alert('Sin evaluación diagnóstica');
              getResourcesModules(idModuleGlobal);
            }
          } else if(this.getAttribute('data-eval')){
            isEval = true;
            idEval = this.getAttribute('data-eval');
            getQuestionsEval(idEval);
            openModule();
          }

        }
      } else {
        $('#modalInsc').modal({
          dismissible: false,
        });
        $('#modalInsc').modal('open');
      }



    });
  }
}

function openModule(){

  if(isMob){
    $('#modalMod').modal('open');
  } else {
    content.style.display = 'block';
    setTimeout(function(){ content.style.maxHeight = content.scrollHeight + 60 + "px";}, 500);
  }
}

function closeModule(){

  if(!isEval){
    sendDataLrs();
    if(stat){ //Módulo terminado
      // alert('Enviando estado del módulo terminado');
      sendStatus('1', modActive);
    }
    stat = false;
  }
  hasFEvaluation = false;
  $('.chip').html('Video - de -');
  isEval= false;
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


function getEvDiag(idEv){
  var formUrl = urlDrawForm + '/' + idEv;

  sendAjax('get',formUrl,'', function(response){
      if(response != null){
        $('#modalEvDiag .modal-content').html(response);
        $('#modalEvDiag').modal({
          dismissible: false
        });
        $('#modalEvDiag').modal('open');
      }
    });
  //$('#modalEvDiag .modal-content').html('Aquí se muestra la evaluación diagnóstica, estamos trabajando en ello');


}

function closeModEvDiag(){
  getResourcesModules(idModuleGlobal);
}

/*Obtiene los recursos desde el controlador*/

function getResourcesModules(idMod){
  //idModule = idMod;
  sendAjax('post',window.location+'/module/get_resources',{
    idModule: idMod,
    _token: $('meta[name="csrf-token"]').attr('content')
  }, function(response){
      if(response != null){
        printResources(response);
      }
    });

}

/*Obtiene el formulario de las preguntas de la evaluaciones
 desde el controlador*/

function getQuestionsEval(idEval){
  var formUrl = urlDrawForm + '/' + idEval;

  sendAjax('get',formUrl,'', function(response){
      if(response != null){
        $("#" + content.id + " #content").html(response);
      }
    });

}

/*imprime los recursos de los modulos*/

function printResources(resources){
  /*Verifica l acantida de recursos en el modulo*/
  if(resources.length > 0){
    var refs = '';
    var contendiv = '';
    $.each(resources[0].references_module, function(index, value) {

        refs += (index+1)+". " + value.content + '<br>';
    })

    if(resources.length > 1){
      var arrVideo = [];
      var arrPdf = [];
      /*guarda los recursos en un arreglo*/
      $.each(resources, function(index, value){
        if(value.type == "video"){
          arrVideo.push(value.url);
        } else if(value.type == "pdf"){
          arrPdf.push(value.url);
        }
      });



      if(arrVideo.length > 0){

        videoSource = '' + arrVideo[0];
        videoStart = 0;

        contendiv += '<video width="100%" controls id="video" controlsList="nodownload">';
        contendiv += '<source src="'+ videoSource +'" type="video/mp4">';
        contendiv += '</video>';
        tincanActivityId = arrVideo[0];
      }

      var contVid = 0;

      $("#"+content.id+" #content").html(contendiv);
      var vide = document.getElementById('video');
      vide.currentTime = videoStart;

      if(arrVideo.length > 0) {
        myActivity = new TinCan.Activity({
          id: 'https://module/' + idModuleGlobal,
          objectType: 'Activity'
        });

        var bookmarkVideoRequest = lrs.retrieveState("videoBookmark", {
          agent: myAgent,
          activity: myActivity,
          callback: function(error, result) {
            if(result != null) {
              bookmarkVideoContent = result.contents;
              videoSource = bookmarkVideoContent.split('|')[0];
              videoStart = bookmarkVideoContent.split('|')[1];
              vidSrc = videoSource.split('storage/');
              //console.log(vidSrc);
              vide.src = '/storage/'+vidSrc[1];;
              vide.currentTime = videoStart;
            }
          }
        });
      }

      vide.onended = function() {

          contVid++;
          if(arrVideo[contVid] != undefined){
            vide.src = ''+arrVideo[contVid];
            tincanActivityId = arrVideo[contVid];
            vide.play();
          } else {
            console.log('video concluido');
            stat = true;
            MsjVideoFinish();
            lrs.dropState("videoBookmark", {
              agent: myAgent,
              activity: myActivity
            });

          }
      };
      vide.onplay = function() {
        videoPlaying = vide;

        //console.log(resources);
        //console.log(vide.src);
        $('.chip').html('Video '+(contVid+1)+' de '+arrVideo.length);
        tincan.sendStatement(
          {
              actor: {
                  name: student_data.name,
                  mbox: "mailto:"+student_data.email
              },
              verb: {
                  id: "http://adlnet.gov/expapi/verbs/attempted"
              },
              object: {
                id: 'http://video/' + tincanActivityId,
                objectType: "Activity"
              }
          }
        );
      };
      vide.onpause = function() {
      }

    } else {

      var contendiv = '';
      switch(String(resources[0]['type'])) {
        case 'video':
            contendiv += '<video width="100%" controls id="video" controlsList="nodownload"><source src="'+resources[0]['url']+'" type="video/mp4"></video>';
            $("#"+content.id+" #content").html(contendiv);
            var vide = document.getElementById('video');

            myActivity = new TinCan.Activity({
              id: 'https://module/' + idModuleGlobal,
              objectType: 'Activity'
            });

            var bookmarkVideoRequest = lrs.retrieveState("videoBookmark", {
              agent: myAgent,
              activity: myActivity,
              callback: function(error, result) {
                if(result != null) {
                  bookmarkVideoContent = result.contents;
                  videoSource = bookmarkVideoContent.split('|')[0];
                  videoStart = bookmarkVideoContent.split('|')[1];
                  vidSrc = videoSource.split('storage/');
                  //console.log(vidSrc[1]);
                  vide.src = '/storage/'+vidSrc[1];
                  vide.currentTime = videoStart;
                }
              }
            });

            vide.onended = function() {
              //console.log('video concluido');
              stat = true;
              MsjVideoFinish();
              lrs.dropState("videoBookmark", {
                agent: myAgent,
                activity: myActivity
              });
            };
            vide.onplay = function() {
              videoPlaying = vide;
              $('.chip').html('Video 1 de 1');
            };
            vide.onpause = function() {

            }
          break;
        case 'pdf':

            contendiv = '<div><button id="prev">Previous</button><button id="next">Next</button>&nbsp; &nbsp;<span>Page: <span id="page_num"></span> / <span id="page_count"></span></span></div><canvas  width="100%" id="the-canvas"></canvas>';
            $("#"+content.id+" #content").html(contendiv);
            printPdfplayer(''+resources[0]['url']);
            tincan.sendStatement(
              {
                  actor: {
                      name: student_data.name,
                      mbox: "mailto:"+student_data.email
                  },
                  verb: {
                      id: "http://adlnet.gov/expapi/verbs/attempted"
                  },
                  object: {
                    id: 'http://pdf/' + resources[0]['url'],
                    objectType: "Activity"
                  }
              }
            );

          break;
      }


    }

    //console.log(refs);

    $("#"+content.id+" #name_module").text(resources[0]['name_module']);
    $("#"+content.id+" #references").html(refs);
    openModule();
  } else {
    $("#"+content.id+" #references").html("Este módulo aún no tiene recursos disponibles, contacte a su administrador.");
    sendAjax('post',window.location +'/save_progress_module',{
      module_id: idModuleGlobal,
      status: 1,
      _token: $('meta[name="csrf-token"]').attr('content')
    }, function(response){
      if(response != null){
        $('#'+mod.id+" div div .modulos").text(response);
      }
    });
    openModule();
  }



}

/*player pdf de los recursos*/

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

/*Envia datos al LRS*/

function sendDataLrs(){
  if(videoPlaying != null){
      console.log(videoPlaying.currentSrc+"  "+videoPlaying.currentTime);
      //lrs.retrieveState("someKey","hola", { agent: myAgent, activity: myActivity });
      myActivity = new TinCan.Activity({
        id: 'https://module/' + idModuleGlobal,
        objectType: 'Activity'
      });
      lrs.saveState("videoBookmark",videoPlaying.currentSrc + '|' + videoPlaying.currentTime, { agent: myAgent, activity: myActivity });
  } else {
      console.log('Video not playing');

  }

}

/*Envia estatus del modulo*/

function sendStatus(status_,mod){
    sendAjax('post',window.location +'/save_progress_module',{
        module_id: idModuleGlobal,
        status:status_,
        _token: $('meta[name="csrf-token"]').attr('content')
      }, function(response){
        if(response != null){
          $('#'+mod.id+" div div .modulos").text(response);
        }
      });

}

/*Cambia la clase de activo al menu*/

function cambiarItem(item){
  //console.log(item)
  $(".activo").each(function() {
      $(this).removeClass('activo');
  })

  if(jQuery.browser.mobile || screen.width <= 992 || window.innerWidth <= 992){
    $("#"+item+'Mob').addClass('activo');
  } else {
    $("#"+item).addClass('activo');
  }

}

function MsjVideoFinish(){
  sendStatus('1', modActive);
  if(hasFEvaluation){
    var toastHTML = "Módulo completado, redirigiendo a evaluación final";
    Materialize.toast(toastHTML,4000,'acept')
    nextUrl = urlFinal.replace('*', idFEvaluation);
    setTimeout(redirectTo(nextUrl), 5000);
  }else{
    var toastHTML = "Módulo completado";
    Materialize.toast(toastHTML,5000,'acept');
    console.log('Recargando la página');
    window.location.href = window.location.href;
  }
}

function redirectTo(route){
  window.location.href = route;
}

function sendAjax(method_,url_,data_,callback){

  //console.log(method_+" "+url_+" "+data_);

  if(method_ == "post"){
    $.ajax({
      type: method_,
      url: url_,
      data: data_,
      success: function (result) {
        //console.log(result);
        callback(result);
      },
      error: function(request, error){
        console.log(error);
      }

    });
  } else if(method_ == "get"){
    $.ajax({
      url: url_,
      method: method_,
      success: function(result){
          callback(result);
      },
      error: function(error){
        callback(result);
      }
    });
  }
}
