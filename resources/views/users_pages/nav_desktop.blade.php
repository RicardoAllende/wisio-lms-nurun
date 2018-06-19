<!-- navbar desktop -->

     <div class="navbar-desktop hide-on-med-and-down">
        @if(isset($ascription))
          <img class="img-navbar-desktop" src="{{ $ascription->getMainImgUrl() }}">
        @else
          <img class="img-navbar-desktop" src="{{ asset('img/logo-navbar.png')}}">
        @endif
        <div class="menu-desktop">

                 @if(Auth::check())
                 @if($ascription->isPharmacy())
                   <ul>
                 @else
                   <ul>
                      <li><a href="#!">Inicio</a></li>
                      <li><a href="#!">¿Qué es un médico con sentido?</a></li>
                      <li><a href="#!">Noticias</a></li>
                 @endif
                 <li><a href="{{ route('student.home', $ascription->slug) }}" id="home">Academia MC</a></li>
                  <ul class="submenu">
                   <li ><a href="{{ route('student.funciona', $ascription->slug) }}" id="funciona">¿Cómo funciona?</a></li>
                   <li ><a href="{{ route('student.own.courses' , $ascription->slug) }}" id="cursos">Cursos</a></li>
                   <li ><a href="{{ route('student.show.experts' , $ascription->slug) }}" id="expertos">Expertos</a></li>
                   <li ><a href="{{ route('student.list.evaluations' , $ascription->slug) }}" id="evaluaciones">Evaluaciones</a></li>
                   <li><a href="#modal2" class="modal-trigger" >Calendario</a> </li>
                   <li><a href="{{ route('certificates.list', $ascription->slug) }}" id="menuCertificados" >Certificados</a></li>
                 @else

                 <ul>
                    <li><a href="#!">Inicio</a></li>
                    <li><a href="#!">¿Qué es un médico con sentido?</a></li>
                    <li><a href="#!">Noticias</a></li>
                 <li><a href="{{ route('student.home', 'invitado') }}" id="home">Academia MC</a></li>
                  <ul class="submenu">
                   <li ><a href="{{ route('student.funciona', 'invitado') }}" id="funciona">¿Cómo funciona?</a></li>
                   <li ><a href="{{ route('student.own.courses' , 'invitado') }}" id="cursos">Cursos</a></li>
                   <li ><a href="{{ route('student.show.experts' , 'invitado') }}" id="expertos">Expertos</a></li>
                   <li ><a href="{{ route('student.list.evaluations' , 'invitado') }}" id="evaluaciones">Evaluaciones</a></li>
                 @endif

               </ul>


              @if(Auth::check())
                @if($ascription->isPharmacy())

                  @else

                  @endif
                <li class="registro"><a href="{{ route('logout') }}" class="btnAcademia"><span class="icon-Page-1 iconmenu"></span><span class="ingresar">Salir</span></a></li>
              @else
                <li><a href="#!">Medicamentos</a></li>
                <li class="registro"><a href="#modal1" class="modal-trigger btnAcademia"><span class="icon-Page-1 iconmenu"></span><span class="ingresar">Ingreso/<br>Registro</span></a></li>
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
