<!-- navbar desktop -->

     <div class="navbar-desktop hide-on-med-and-down">
        <img class="img-navbar-desktop" src="{{ asset('img/logo-navbar.png')}}">
        <div class="menu-desktop">
           <ul>
              <li><a href="#!">Inicio</a></li>
              <li><a href="#!">¿Qué es un médico con sentido?</a></li>
              <li><a href="#!">Noticias</a></li>


                 @if(Auth::check())
                 <li><a href="{{ route('student.home', Auth::user()->ascription()->slug) }}" id="home">Academia MC</a></li>
                  <ul class="submenu">
                   <li ><a href="{{ route('student.funciona', Auth::user()->ascription()->slug) }}" id="funciona">¿Cómo funciona?</a></li>
                   <li ><a href="{{ route('student.own.courses' , Auth::user()->ascription()->slug) }}" id="cursos">Cursos</a></li>
                   <li ><a href="{{ route('student.show.experts' , Auth::user()->ascription()->slug) }}" id="expertos">Expertos</a></li>
                   <li ><a href="{{ route('student.own.courses' , Auth::user()->ascription()->slug) }}" id="evaluaciones">Evaluaciones</a></li>
                 @else
                 <li><a href="{{ route('student.home', 'invitado') }}" id="home">Academia MC</a></li>
                  <ul class="submenu">
                   <li ><a href="{{ route('student.funciona', 'invitado') }}" id="funciona">¿Cómo funciona?</a></li>
                   <li ><a href="{{ route('student.own.courses' , 'invitado') }}" id="cursos">Cursos</a></li>
                   <li ><a href="{{ route('student.show.experts' , 'invitado') }}" id="expertos">Expertos</a></li>
                   <li ><a href="{{ route('student.own.courses' , 'invitado') }}" id="evaluaciones">Evaluaciones</a></li>
                 @endif

               </ul>
              <li><a href="#!">Calendario</a></li>
              <li><a href="#!">Medicamentos</a></li>
              @if(Auth::check())
                <li class="registro"><a href="{{ route('logout') }}"><span class="icon-Page-1 iconmenu"></span><span class="ingresar">Salir</span></a></li>
              @else
                <li class="registro"><a href="#modal1" class="modal-trigger"><span class="icon-Page-1 iconmenu"></span><span class="ingresar">Ingreso/<br>Registro</span></a></li>
              @endif

           </ul>
        </div>
     </div>
      <!-- header sitio exclusivo -->
      <div class="row sizefont hide-on-med-and-down">
           <div class="col s2 l1">

           </div>
           <div class="col s8 l10">
               Este sitio es exclusivo para profesionales de la salud en México
           </div>
           <div class="col s2 l1">
                <img src="{{ asset('img/LOGO.png')}}" class="responsive-img">
           </div>

      </div>

@include('users_pages.login.modal')
