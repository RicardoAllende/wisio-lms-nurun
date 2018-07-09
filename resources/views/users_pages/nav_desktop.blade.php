<!-- navbar desktop -->

     <div class="navbar-desktop hide-on-med-and-down">
        @if(isset($ascription))
          <a href="{{ route('student.home', $ascription->slug) }}"><img class="img-navbar-desktop" src="{{ $ascription->getMainImgUrl() }}"></a>
        @else
          <a href="{{ route('student.home', $ascription->slug) }}"><img class="img-navbar-desktop" src="{{ asset('img/logo_Academia.png')}}"></a>
        @endif
        <div class="menu-desktop">

            <ul>
              <li><a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Academia_mc'});" 
              href="{{ route('student.home', $ascription->slug) }}" id="home">Academia MC</a></li>
              <ul class="submenu">
              @if(Auth::check())

                  <li ><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Como_funciona'});"
                   href="{{ route('student.funciona', $ascription->slug) }}" id="funciona">¿Cómo funciona?</a></li>
                  <li><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Mis_cursos'});" 
                  href="{{ route('student.own.courses', $ascription->slug) }}" id="cursos">Cursos</a></li>
                  
                  <li><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Profesores'});" 
                  href="{{ route('student.show.experts', $ascription->slug) }}" id="expertos">Profesores</a></li>
                  <li><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Evaluaciones'});"
                  href="{{ route('student.list.evaluations', $ascription->slug) }}" id="evaluaciones">Evaluaciones</a></li>
                  <!-- <li><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Calendario'});"
                  href="#modal2" class="modal-trigger" >Calendario</a> </li> -->
                  <li><a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Certificados'});"
                  href="{{ route('certificates.list', $ascription->slug) }}" id="menuCertificados" >Certificados</a></li>
                </ul>
                <!-- <li><a href="#!">Medicamentos</a></li> -->
                  <li class="registro">
                    <a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Salir'});"
                     href="{{ route('logout') }}" class="btnAcademiaL">
                      <span class="icon-Page-1 iconmenu"></span><span class="ingresar">Salir</span>
                    </a>
                  </li>



              @else 
                
                  <li ><a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Como_funciona'});"
                   href="{{ route('student.funciona', $ascription->slug) }}" id="funciona">¿Cómo funciona?</a></li>
                  <li><a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Cursos'});"
                   href="{{ route('student.own.courses', $ascription->slug) }}" id="cursos">Mis cursos</a></li>
                  
                  <li><a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Profesores'});" href="{{ route('student.show.experts', $ascription->slug) }}" id="expertos">Profesores</a></li>
                </ul>
                <!-- <li><a href="#!">Medicamentos</a></li> -->
                  <li class="registro">
                    <a href="#modal1" class="modal-trigger btnAcademiaL" onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Ingreso_Registro'});">
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
