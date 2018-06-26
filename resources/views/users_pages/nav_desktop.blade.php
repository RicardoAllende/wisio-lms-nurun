<!-- navbar desktop -->

     <div class="navbar-desktop hide-on-med-and-down">
        @if(isset($ascription))
          <img class="img-navbar-desktop" src="{{ $ascription->getMainImgUrl() }}">
        @else
          <img class="img-navbar-desktop" src="{{ asset('img/logo_Academia.png')}}">
        @endif
        <div class="menu-desktop">

            <ul>
              @if( $ascription->isMainAscription() )
                <!-- <li><a href="#!">Inicio</a></li>
                <li><a href="#!">¿Qué es un médico con sentido?</a></li>
                <li><a href="#!">Contenido Médico</a></li> -->
              @endif
              <li><a href="{{ route('student.home', $ascription->slug) }}" id="home">Academia MC</a></li>
              <ul class="submenu">
                <li ><a href="{{ route('student.funciona', $ascription->slug) }}" id="funciona">¿Cómo funciona?</a></li>
                @if(Auth::check())
                  <li><a href="{{ route('student.own.courses', $ascription->slug) }}" id="cursos">Mis cursos</a></li>
                @else
                  <li><a href="{{ route('show.pharmacy.landing.page', $ascription->slug) }}" id="cursos">Cursos</a></li>
                @endif
                <li><a href="{{ route('student.show.experts', $ascription->slug) }}" id="expertos">Profesores</a></li>
                @if(Auth::check())
                  <li><a href="{{ route('student.list.evaluations', $ascription->slug) }}" id="evaluaciones">Evaluaciones</a></li>
                  <li><a href="#modal2" class="modal-trigger" >Calendario</a> </li>
                  <li><a href="{{ route('certificates.list', $ascription->slug) }}" id="menuCertificados" >Certificados</a></li>
                @endif
              </ul>
              <!-- <li><a href="#!">Medicamentos</a></li> -->
              @if(Auth::check())
                <li class="registro">
                  <a href="{{ route('logout') }}" class="btnAcademia">
                    <span class="icon-Page-1 iconmenu"></span><span class="ingresar">Salir</span>
                  </a>
                </li>
              @else
                <li class="registro">
                  <a href="#modal1" class="modal-trigger btnAcademia">
                    <span class="icon-Page-1 iconmenu"></span><span class="ingresar">Ingreso/<br>Registro</span>
                  </a>
                </li>
              @endif
            </ul>

        </div>
     </div>
      <!-- header sitio exclusivo -->
      <div class="row sizefont hide-on-med-and-down">
           <div class="col s2 l1">

           </div>
           <div class="col s8 l10">
             <span id="font-down">-A</span>
             <span id="font-up">A+</span>
               Este sitio es exclusivo para profesionales de la salud en México
           </div>
           <div class="col s2 l1">
                <img src="{{ asset('img/LOGO.png')}}" class="responsive-img">
           </div>

      </div>
@include('users_pages.login.modal')
