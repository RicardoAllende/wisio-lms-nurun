<html>
<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

   <title>Academia Sanofi | 404</title>

   <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages/materialize.css')}}"  media="screen,projection"/>
   <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages.css')}}" />
   <link type="text/css" rel="stylesheet" href="{{ asset('/css/styles_users_pages/iconsAcademia.css')}}" />



</head>

<body>
  <div class="row" style="padding: 3%;">
      <div class="col s8 l10">
        <hr class="line"/>
      </div>
      <div class="col s4 l2">
        <img src="{{ asset('img/logo_Academia.png')}}" class="responsive-img">
      </div>

      <div class="col s12 center" >
        <h4 style="color: #3360C1; font-size: 5em; font-weight:900;">ERROR</h4>
        <h2 style="color: #3360C1; font-size: 5em; font-weight:900;">PERMISO DENEGADO</h2>
        <h5>NO TIENE PERMISO PARA ACCEDER A ESTA SECCIÓN</h5>
        <br>
      </div>
      <center><a href="{{ route('login')}}">Volver al Inicio <span class="icon-registrese iconbtn"></span></a></center>
  </div>


</body>
<script>
  // Automatic redirect
  setTimeout(function(){ window.location = "{{ url('/') }}"; }, 2000);
</script>
</html>
