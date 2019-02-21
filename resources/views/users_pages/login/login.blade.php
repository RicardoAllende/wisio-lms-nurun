@section('title') Cursos @stop 
@section('metadata')
<meta
    name="description"
    content="Conoce los diferentes cursos que tenemos disponibles para ti, avalados por las asociasiones médicas más importantes del país."
/>
<meta name="keywords" content="Cursos, exámenes, capacitación, Sanofi" />
@endsection 
@extends('users_pages.master') 
@section('body')
<!-- Home sin login -->
<div class="row pad-left" id="presentacion">
    <div class="col s12 l6 aux-padding">
        <h3>{{ $ascription->description }}</h3>
        <h5 class="negro">
            Wisio LMS es una plataforma desarrollada por Subitus dedicada a brindar educación médica continua en línea.
        </h5>

        <div class="row sesion">
            <div class="col s12 l6 btnAcademiaMobi">
                <a
                    onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Inicie_Sesion'});"
                    href="#modal1"
                    class="modal-trigger btnAcademia"
                    >INICIE SESIÓN <span class="icon-sesion iconbtn"></span
                ></a>
            </div>
            <div class="col s12 l6 btnAcademiaMobi">
                @if(isset($ascription))
                <a
                    onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Registrarse'});"
                    href="{{ route('show.register.form.pharmacy', $ascription->slug)}}"
                    class="btnAcademia"
                >
                    REGÍSTRESE <span class="icon-registrese iconbtn"></span
                ></a>
                @else
                <a
                    onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Registrarse'});"
                    href="{{ route('register') }}"
                    class="btnAcademia"
                >
                    REGÍSTRESE <span class="icon-registrese iconbtn"></span
                ></a>
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
        <img src="/img/img1.jpg" class="img-principal" />
    </div>
</div>

@include('users_pages.courses.newest') @stop 
@section('extrajs')
<script>
    cambiarItem("home");
</script>

@stop
