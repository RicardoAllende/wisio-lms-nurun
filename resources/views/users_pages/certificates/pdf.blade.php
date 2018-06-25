
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Language" content="es"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<style>


        body{
            font-family: "Gill Sans Extrabold", Helvetica, sans-serif;
        }

        #nombre1{
            position: fixed;
            left: 320px;
            top: 245px;
            font-size: 22pt;
            width: 700px;
            text-align: left;
            color: #2052a6;
            font-weight: 700;
        }
        #dia1{
            position: fixed;
            top: 368px;
            left: 295px;
            font-size: 16pt;
            color: #396db6;
        }
        #dia2{
          position: fixed;
          top: 368px;
          left: 490px;
          font-size: 16pt;
          color: #396db6;
        }

        #mes1{
          position: fixed;
          top: 368px;
          left: 390px;
          font-size: 16pt;
          color: #396db6;
        }

        #mes2{
          position: fixed;
          top: 368px;
          left: 590px;
          font-size: 16pt;
          color: #396db6
        }

        #anio{
          position: fixed;
          top: 368px;
          left: 685px;
          font-size: 16pt;
          color: #396db6
        }

        #curso1{
            position: fixed;
            top: 330px;
            left: 80px;
            font-size: 22pt;
            color: #2052a6;
            font-weight:700;
            width: 500px;
        }

        img {
            position: fixed;
        }
	</style>
</head>

<body>

    <div >
        <img src="{{ asset('img/cert_1_sanofi.png')}}" width="1024px" height="750px">
        <div id="nombre1">
            {{ (isset($user)) ? $user->fullname : 'JULIA ALEJANDRA CHÁVEZ ZAPATA' }}
        </div>
        <div id="curso1">{{ (isset($course)) ? $course->name : 'PAEC Trombosis' }}</div>
        <?php
            $di = new DateTime($pivot->created_at);
            $df = new DateTime($pivot->updated_at);

          ?>
        <div id="dia1">{{ $di->format('d') }}</div>
        <div id="mes1">{{ $di->format('m') }}</div>
        <div id="dia2">{{ $df->format('d') }}</div>
        <div id="mes2">{{ $df->format('m') }}</div>
        <div id="anio">20{{ $df->format('y') }}</div>
    </div>
</body>
</html>
