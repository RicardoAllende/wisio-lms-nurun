
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
        }

        #nombre1{
            position: fixed;
            left: 280px;
            top: 372px;
            font-size: 22pt;
            width: 700px;
            text-align: left;
            color: #2052a6;
            font-weight: 700;
        }

        #dia2{
          position: fixed;
          top: 478px;
          left: 704px;
          font-size: 12pt;
          color: #66767e;
          font-weight: 900;
        }

        #mes2{
          position: fixed;
          top: 478px;
          left: 764px;
          font-size: 12pt;
          color: #66767e;
          font-weight: 900;
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
        <img src='storage/constancias/DIABETES_1_V2.png' class="front" width="1024px" height="750px">
        <div id="nombre1">
            {{ (isset($user)) ? $user->fullname : 'JULIA ALEJANDRA CHÁVEZ ZAPATA' }}
        </div>
        <!-- <div id="curso1">{{ (isset($course)) ? $course->name : 'PAEC Diabetes' }}</div> -->
        <?php
            if(isset($pivot)){
              $di = new DateTime($pivot->created_at);
              $df = new DateTime($pivot->updated_at);
            } else {
              $di = new DateTime('02/05/2018');
              $df = new DateTime('05/05/2018');
            }


          ?>
        <!-- <div id="dia1">{{ $di->format('d') }}</div>
        <div id="mes1">{{ $di->format('m') }}</div> -->
        <div id="dia2">{{ $df->format('d') }}</div>
        <div id="mes2">{{ $df->format('m') }}</div>
        <!-- <div id="anio">20{{ $df->format('y') }}</div> -->
        <img src="storage/constancias/DIABETES_1_V2_VLTA.png" width="1024px" height="750px">
    </div>
</body>
</html>