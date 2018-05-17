@section('title')
Login
@stop
@extends('users_pages.master')
@section('body')
<!-- Home sin login -->
         <div class="row pad-left3">

            <div class="col s12 l6 aux-padding">

               <p class="negro">Academia es un espacio dedicado de Sanofi para brindar educación médica continua. En este espacio podrá encontrar capacitación y certificación constante, disponible las 24 horas del día. Todos nuestros cursos son avalados por CONAMEGE</p>

                <div class="row sesion">
                    <div class="col s12 l6 aprender-mas">
                  <a href="#modal1" class="modal-trigger"
                  >INICIE SESIÓN <span class="icon-sesion iconbtn"></span></a>
               </div>
                <div class="col s12 l6 aprender-mas">
                  <a href="#!">REGÍSTRESE <span class="icon-registrese iconbtn"></span></a>

               </div>
                </div>
                <div class="row sesion hide-on-med-and-down">
                    <div class="col s12 l6 aprender-mas">
                  <a href="#!">VER MÁS <span class="icon-mas iconbtn"></span></a>

               </div>
                <div class="col s12 l6 aprender-mas">


               </div>
                </div>

            </div>
             <div class="col s12 l6" id="img1">
               <img src="img/img1.JPG" class="img-principal">
            </div>


         </div>
         @include('users_pages.login.modal')
         @include('users_pages.courses.newest')
@stop
