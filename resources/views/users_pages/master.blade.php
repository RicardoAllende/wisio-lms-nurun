<!DOCTYPE html>
<html lang="es-mx">
   <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <title>Academia Sanofi | @yield('title')</title>

      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
      <link type="text/css" rel="stylesheet" href="css/style.css" />
      <link type="text/css" rel="stylesheet" href="css/iconsAcademia.css" />

      @yield('extracss')

   </head>
   <body>

     @include('nav_mobile')
     @include('nav_desktop')

     <!-- Contenido -->
      <div class="row contenido">
          <!-- Logo academia -->
          <div class="row pad-left3">
              <div class="col s6 l10">
                <hr class="line"/>
              </div>
              <div class="col s6 l2">
                <img src="img/logo_Academia.png" class="responsive-img">
              </div>
              <p class="user">Dr. {{  }}</p>
          </div>

          @yield('body')

          @include('footer')

      </div>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/script.js"></script>

      @yield('extrajs')

  </body>
</html>
