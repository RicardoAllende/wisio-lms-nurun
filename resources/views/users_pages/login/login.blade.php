@section('title')
Cursos
@stop

@section('metadata')
  <meta name="description" content="Conóce los diferentes cursos que tenemos disponibles para ti, avalados por las asociasiones médicas más importantes del país.">
  <meta name="keywords" content="Cursos, exámenes, capacitación, Sanofi">
@endsection

@extends('users_pages.master')
@section('body')
<!-- Home sin login -->
         <div class="row pad-left">

            <div class="col s12 l6 aux-padding">

               <p class="negro">Academia es una plataforma de Sanofi dedicada a brindar educación médica continua en línea. En este espacio usted podrá encontrar capacitación constante, disponible en cualquier momento y en cualquier lugar. Todos nuestros cursos están avalados por algunas de las asociaciones médicas más importantes del país</p>

                <div class="row sesion">
                    <div class="col s12 l6 btnAcademiaMobi">
                  <a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Inicie_Sesion'});" href="#modal1" class="modal-trigger btnAcademia"
                  >INICIE SESIÓN <span class="icon-sesion iconbtn"></span></a>
               </div>
                <div class="col s12 l6 btnAcademiaMobi">

                  @if(isset($ascription))
                    <a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Registrarse'});" href="{{ route('show.register.form.pharmacy', $ascription->slug)}}" class="btnAcademia"> REGÍSTRESE <span class="icon-registrese iconbtn"></span></a>
                  @else
                    <a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Registrarse'});" href="{{ route('register')}}" class="btnAcademia"> REGÍSTRESE <span class="icon-registrese iconbtn"></span></a>
                  @endif

               </div>
                </div>
                <!-- <div class="row sesion hide-on-med-and-down">
                    <div class="col s12 l6">
                  <a href="#!" class="btnAcademia">VER MÁS <span class="icon-mas iconbtn"></span></a>

               </div>
                <div class="col s12 l6 aprender-mas">


               </div>
                </div> -->

            </div>
             <div class="col s12 l6" id="img1">
               <img src="/img/img1.jpg" class="img-principal">
            </div>


         </div>

         @include('users_pages.courses.newest')
         
@stop
@section('extrajs')
<script>
  cambiarItem("home");
</script>

@stop
