<!-- navbar mobile -->
       <div class="row sizefont hide-on-large-only">
            <div class="col s2 l1">

            </div>
            <div class="col s8 l10">
                Este sitio es exclusivo para profesionales de la salud en México
            </div>
            <div class="col s2 l1">
                 <img src="{{ asset('img/LOGO.png')}}" class="responsive-img">
            </div>

       </div>
      <nav class="hide-on-large-only z-depth-0">
         <div class="nav-wrapper">

            <a href="#" data-activates="mobile-demo" class="button-collapse" id="btnMenu"><i class="material-icons">menu</i></a>
             <a href="#!" class="brand-logo"><img src="{{ asset('img/logo-navbar.png')}}" class="responsive-img"></a>
             <div class="menu-mobile">
              <ul class="side-nav" id="mobile-demo">
                <li><a href="#!">Inicio</a></li>
                <hr class="linem"/>
                <li><a href="#!">¿Qué es un médico con sentido?</a></li>
                <hr class="linem"/>
                <li><a href="#!">Noticias</a></li>
                <hr class="linem"/>

                   @if(Auth::check())
                   <li><a href="{{ route('student.home', $ascription->slug) }}" id="home">Academia MC</a></li>
                    <ul class="submenu">
                     <li ><a href="{{ route('student.funciona', $ascription->slug) }}" id="funciona">¿Cómo funciona?</a></li>
                     <li ><a href="{{ route('student.own.courses' , $ascription->slug) }}" id="cursos">Cursos</a></li>
                     <li ><a href="{{ route('student.show.experts' , $ascription->slug) }}" id="expertos">Expertos</a></li>
                     <li ><a href="{{ route('student.list.evaluations' , $ascription->slug) }}" id="evaluaciones">Evaluaciones</a></li>
                   @else
                   <li><a href="{{ route('student.home', 'invitado') }}" id="home">Academia MC</a></li>
                    <ul class="submenu">
                     <li ><a href="{{ route('student.funciona', 'invitado') }}" id="funciona">¿Cómo funciona?</a></li>
                     <li ><a href="{{ route('student.own.courses' , 'invitado') }}" id="cursos">Cursos</a></li>
                     <li ><a href="{{ route('student.show.experts' , 'invitado') }}" id="expertos">Expertos</a></li>
                     <li ><a href="{{ route('student.list.evaluations' , 'invitado') }}" id="evaluaciones">Evaluaciones</a></li>
                   @endif

                 </ul>
                 <hr class="linem"/>
                <li><a href="#!">Medicamentos</a></li>
                <hr class="linem"/>
                @if(Auth::check())
                  <li class="modal-trigger" href="#modal2"><a href="#">Calendario</a> </li>
                  <hr class="linem"/>
                  <li class="registro"><a href="{{ route('logout') }}"><span class="icon-Page-1 iconmenu"></span><span class="ingresar">Salir</span></a></li>
                  <hr class="linem"/>
                @else
                  <li class="registro"><a href="#modal1" class="modal-trigger"><span class="icon-Page-1 iconmenu"></span><span class="ingresar">Ingreso/Registro</span></a></li>
                @endif
              </ul>
          </div>
         </div>
      </nav>
