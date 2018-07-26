
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Language" content="es"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<style>


        body{
            font-family: "Lato", Helvetica, sans-serif;
            text-transform: uppercase;
        }

        #nombre1{
            position: fixed;
            left: 280px;
            top: 385px;
            font-size: 22pt;
            width: 700px;
            text-align: left;
            color: #2052a6;
            font-weight: 700;
        }

        #dia2{
          position: fixed;
          top: 458px;
          left: 681px;
          font-size: 13pt;
          color: #66767e;
          font-weight: bold;
        }

        #mes2{
          position: fixed;
          top: 459px;
          left: 767px;
          font-size: 13pt;
          color: #66767e;
          font-weight: bold;
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

        .front {
            position: fixed;
            top: 0;
            left: 0;

        }
        .reverse{
          position: fixed;
          top: 760px;
          left: 0;
        }
	</style>
</head>

<body>

    <div >
        <img src='storage/constancias/hipertension.png' class="front" width="1024px" height="750px">
        <div id="nombre1">
            {{ (isset($user)) ? $user->fullname : 'JULIA ALEJANDRA CHÁVEZ ZAPATA' }}
        </div>
        <!-- <div id="curso1">{{ (isset($course)) ? $course->name : 'PAEC Diabetes' }}</div> -->
        <?php
            if(isset($pivot)){
              $di = new DateTime($pivot->created_at);
              $df = new DateTime($pivot->updated_at);
              $month = $months[$df->format('m') - 1];
            } else {
              $di = new DateTime('02/05/2018');
              $df = new DateTime('05/5/2018');
            }


          ?>
        <!-- <div id="dia1">{{ $di->format('d') }}</div>
        <div id="mes1">{{ $di->format('m') }}</div> -->
        <div id="dia2">{{ $df->format('d') }}</div>
        <div id="mes2">{{ $month }}</div>
        <!-- <div id="anio">20{{ $df->format('y') }}</div> -->
        <img src="storage/constancias/hipertension_vuelta.png" width="1024px" height="750px">
    </div>
</body>
</html>
