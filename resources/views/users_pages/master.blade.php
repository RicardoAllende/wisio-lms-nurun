<!DOCTYPE html>
<html lang="es-mx">
   <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <title>Academia Sanofi | @yield('title')</title>

      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages/materialize.min.css')}}"  media="screen,projection"/>
      <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages/iconsAcademia.css')}}" />

      @yield('extracss')

   </head>
   <body>

     @include('users_pages.nav_mobile')
     @include('users_pages.nav_desktop')

     <!-- Contenido -->
      <div class="row contenido">
          <!-- Logo academia -->
          <div class="row pad-left3">
              <div class="col s8 l10">
                <hr class="line"/>
              </div>
              <div class="col s4 l2">
                <img src="{{ asset('img/logo_Academia.png')}}" class="responsive-img">
              </div>
              @if (Auth::check())
                <p class="user">Dr. {{ Auth::user()->firstname." ".Auth::user()->lastname }}</p>
              @endif
          </div>

          <div id="modal2" class="modal">
            <div class="modal-content">
            <center>
                <img src="{{ config('constants.default_images.evaluation') }}" style="width:80%; height:80%;" alt="Calendario">      
            </center>
            </div>
            <div class="modal-footer">
              <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
          </div>
          @yield('body')
          @include('users_pages.footer')

      </div>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="{{ asset('/js/js_users_pages/materialize.min.js')}}"></script>
      <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
      <script src="{{ asset('/js/js_users_pages/checkMobile.js')}}"></script>
      <script type="text/javascript" src="{{ asset('/js/js_users_pages/script.js')}}"></script>

      @yield('extrajs')

  </body>
</html>
