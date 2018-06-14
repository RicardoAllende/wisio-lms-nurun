<!DOCTYPE html>
<html lang="es-mx">
   <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <title>Academia Sanofi | @yield('title')</title>

      <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
          <div class="row breads">
            <div class="col s12 l6">
              @yield('breadcrumbs')
            </div>
            <div class="col l6 hide-on-med-and-down right-align ">
                <a href="" class="links">Contacto</a>
                <a href="{{ route('student.update') }}" class="links">Editar Perfil</a>
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
                <p class="user pad-left3">Dr. {{ Auth::user()->firstname." ".Auth::user()->lastname }}</p>
              @endif
          </div>

          @yield('body')
          @include('users_pages.calendario.modal')
          @include('users_pages.footer')

      </div>
      <script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="{{ asset('/js/js_users_pages/materialize.min.js')}}"></script>
      <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
      <script type="text/javascript" src="{{ asset('/js/js_users_pages/configModal.js')}}"></script>
      <script src="{{ asset('/js/js_users_pages/checkMobile.js')}}"></script>
      <script type="text/javascript" src="{{ asset('/js/js_users_pages/script.js')}}"></script>

      @if(session()->has('msj'))
      <script>
        var toastHTML = "{{ session('msj') }}"
        Materialize.toast(toastHTML,3000,'acept')
      </script>
      @endif
      @if(session()->has('error'))
      <script>
        var toastHTML = "{{ session('error') }}"
        Materialize.toast(toastHTML,3000,'error')
      </script>
      @endif

      @yield('extrajs')

  </body>
</html>
