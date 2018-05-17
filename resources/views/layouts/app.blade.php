<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración Academia - @yield('title') </title>


    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    <link rel="stylesheet" type="text/css" href="/css/plugins/dataTables/datatables.min.css">
    <link rel="shortcut icon" href="/favicon.ico" />
    @section('styles')
    @show

</head>
<body>

  <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">

            <!-- Page wrapper -->
            @include('layouts.topnavbar')

            @include('layouts.title')

            <!-- Main view  -->
            @yield('content')

            <!-- Footer -->
            @include('layouts.footer')

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
<script type="text/javascript" src="/js/plugins/dataTables/datatables.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    if($('.dataTables').length > 0){
      $('.dataTables').DataTable();
    }
  });
</script>
@section('scripts')
@show

</body>
</html>
