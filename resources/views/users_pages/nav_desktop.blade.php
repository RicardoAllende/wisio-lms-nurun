<!-- navbar desktop -->

     <div class="navbar-desktop hide-on-med-and-down">
        <img class="img-navbar-desktop" src="{{ asset('img/logo-navbar.png')}}">
        <div class="menu-desktop">
           <ul>
              <li><a href="#!" class="activo">Inicio</a></li>
              <li><a href="#!">¿Qué es un médico con sentido?</a></li>
              <li><a href="#!">Noticias</a></li>


                 @if(Auth::check())
                 <li><a href="{{ route('student.home', Auth::user()->ascription()->slug) }}" class="activo">Academia MC</a></li>
                  <ul class="submenu">
                 <li><a href="{{ route('student.funciona', Auth::user()->ascription()->slug) }}">¿Cómo funciona?</a></li>
                 <li><a href="{{ route('student.own.courses' , Auth::user()->ascription()->slug) }}">Cursos</a></li>
                 <li><a href="{{ route('student.show.experts' , Auth::user()->ascription()->slug) }}">Expertos</a></li>
                 <li><a href="{{ route('student.own.courses' , Auth::user()->ascription()->slug) }}">Evaluaciones</a></li>
                 @else
                 <li><a href="{{ route('student.home', 'invitado') }}" class="activo">Academia MC</a></li>
                  <ul class="submenu">
                 <li><a href="{{ route('student.funciona', 'invitado') }}">¿Cómo funciona?</a></li>
                 <li><a href="{{ route('student.own.courses' , 'invitado') }}">Cursos</a></li>
                 <li><a href="{{ route('student.show.experts' , 'invitado') }}">Expertos</a></li>
                 <li><a href="{{ route('student.own.courses' , 'invitado') }}">Evaluaciones</a></li>
                 @endif

               </ul>
              <li><a href="#!">Calendario</a></li>
              <li><a href="#!">Medicamentos</a></li>
              <li><a href="#!">Ingreso/Registro</a></li>
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
