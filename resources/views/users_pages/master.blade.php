<!DOCTYPE html>
<html lang="es-mx">
   <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <title>@yield('title') | Academia MC</title>
      @yield('metadata')
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-121926332-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-121926332-1');
      </script>

      <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages/materialize.css')}}"  media="screen,projection"/>
      <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages/iconsAcademia.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages.css')}}" />


      @yield('extracss')

   </head>
   <body>
      @if( ! Auth::check())
        @include('users_pages.login.modal')
      @endif
     @include('users_pages.nav_mobile')
     @include('users_pages.nav_desktop')

     <!-- Contenido -->
     <div id="contenedor">
       <div class="contenido">
           <!-- Logo academia -->

           <div class="row breads">
             <div class="col s12 l6">
               @if (Auth::check())
                 @yield('breadcrumbs')
               @endif
             </div>
             <div class="col l6 hide-on-med-and-down right-align ">
               @if (Auth::check())
                 <a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Contacto'});"
                 href="" class="links">Contacto</a>
                 <a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Editar Perfil'});"
                 href="{{ route('student.update') }}" class="links">Editar Perfil</a>
               @else
               <!-- <a href="" class="links">Compartir <i class="tiny material-icons">share</i></a> -->
               <!-- <a class="links" onclick="window.print();">Imprimir <i class="tiny material-icons">local_printshop</i></a> -->
               @endif
             </div >
           </div>

           <div class="row">
               <div class="col s8 l10">
                 <hr class="line"/>
               </div>
               <div class="col s4 l2">
                 <img src="{{ asset('img/logo_Academia.png')}}" class="responsive-img">
               </div>
               @if (Auth::check())
                 <h4 class="user pad-left3">Dr. {{ Auth::user()->firstname." ".Auth::user()->lastname }}</h4>
               @endif
           </div>



           @yield('body')
           @include('users_pages.calendario.modal')


       </div>
       <div class="row hide-on-large-only right-align">
         <a  href="#contenedor" class="btnAcademia"> Arriba <span class="icon-bt_arriba iconbtn"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></a>
       </div>
       @include('users_pages.footer')
     </div>




      <script type="text/javascript" src="{{ asset('/js/jquery-3.1.0.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('/js/js_users_pages/materialize.min.js') }}"></script>
      <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
      <script type="text/javascript" src="{{ asset('/js/js_users_pages/configModal.js') }}"></script>
      <script src="{{ asset('/js/js_users_pages/checkMobile.js')}}"></script>
      <script type="text/javascript" src="{{ asset('/js/js_users_pages/script.js')}}"></script>
      @if(session()->has('msj'))
      <script>
        var toastHTML = "{{ session('msj') }}"
        Materialize.toast(toastHTML,4000,'acept')
      </script>
      @endif
      @if(session()->has('error'))
      <script>
        var toastHTML = "{{ session('error') }}"
        Materialize.toast(toastHTML,4000,'error')
      </script>
      @endif

      @yield('extrajs')
    <!--<script src="/js/google_tracking.js"></script>-->
  </body>
</html>
