<!-- navbar mobile -->
       <div class="row sizefont hide-on-large-only">
            <div class="col s2 l1">
              <span id="font-downMob">-A</span>&nbsp;&nbsp;
              <span id="font-upMob">A+</span>
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

            @if(isset($ascription))
              <a href="#!" class="brand-logo right"><img src="{{ $ascription->getMainImgUrl() }}" class="responsive-img"></a>
            @else
              <a href="#!" class="brand-logo right"><img src="{{ asset('img/logo-navbar.png')}}" class="responsive-img"></a>
            @endif


             <div class="menu-mobile">
              <ul class="side-nav" id="mobile-demo">
                <!-- <li><a href="#!">Inicio</a></li>
                <hr class="linem"/>
                <li><a href="#!">¿Qué es un médico con sentido?</a></li>
                <hr class="linem"/>
                <li><a href="#!">Contenido Médico</a></li>
                <hr class="linem"/> -->

                   @if(Auth::check())
                   <li><a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Academia_mc'});"
                    href="{{ route('student.home', $ascription->slug) }}" href="{{ route('student.home', $ascription->slug) }}" id="homeMob">Academia MC</a></li>
                    <ul class="submenu">
                      <li ><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Como_funciona'});"
                      href="{{ route('student.funciona', $ascription->slug) }}" id="funcionaMob">¿Cómo funciona?</a></li>
                      <li ><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Mis_cursos'});" 
                      href="{{ route('student.own.courses' , $ascription->slug) }}" id="cursosMob">Mis cursos</a></li>
                      <li ><a  onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Profesores'});" 
                      href="{{ route('student.show.experts' , $ascription->slug) }}" id="expertosMob">Profesores</a></li>
                      <li ><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Evaluaciones'});"
                      href="{{ route('student.list.evaluations' , $ascription->slug) }}" id="evaluacionesMob">Evaluaciones</a></li>
                      <!-- <li><a href="#modal2" class="modal-trigger" >Calendario</a> </li> -->
                      <li><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Certificados'});"
                      href="{{ route('certificates.list', $ascription->slug) }}" id="menuCertificados" >Certificados</a></li>
                      <li>
                        <a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Contacto'});"
                        href="{{ route('contact', $ascription->slug) }}">Contacto</a>
                      </li>
                   @else
                   <li><a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Academia_mc'});"
                    href="{{ route('student.home', $ascription->slug) }}" id="home">Academia MC</a></li>
                    <ul class="submenu">
                     <li ><a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Como_funciona'});" 
                     href="{{ route('student.funciona', $ascription->slug) }}" id="funcionaMob">¿Cómo funciona?</a></li>
                     <li ><a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Cursos'});" 
                     href="{{ route('student.own.courses' , $ascription->slug) }}" id="cursosMob">Cursos</a></li>
                     <li ><a  onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Profesores'});" 
                     href="{{ route('student.show.experts' , $ascription->slug) }}" id="expertosMob">Profesores</a></li>
                      <li>
                        <a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Contacto'});"
                        href="{{ route('contact', $ascription->slug) }}">Contacto</a>
                      </li>

                   @endif

                 </ul>
                 <!-- <hr class="linem"/> -->
                <!-- <li><a href="#!">Medicamentos</a></li> -->
                <hr class="linem"/>
                @if(Auth::check())
                  <li class="registro">
                    <a href="{{ route('logout') }}" onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Salir'});">
                      <span class="icon-Page-1 iconmenu"></span><span class="ingresar">Salir
                      </span>
                    </a>
                  </li>
                  <hr class="linem"/>
                @else
                  <li>
                    <a href="#modal1" class="modal-trigger"
                     onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Ingreso_Registro'});" >
                      <span class="icon-Page-1 iconmenu"></span><span class="ingresar">Ingreso/Registro</span>
                    </a>
                  </li>
                @endif
              </ul>
          </div>
         </div>
      </nav>
