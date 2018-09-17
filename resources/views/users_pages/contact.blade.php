@section('title')
Cursos
@stop

@section('metadata')
  <meta name="description" content="Conóce los diferentes cursos que tenemos disponibles para ti, avalados por las asociasiones médicas más importantes del país.">
  <meta name="keywords" content="Cursos, exámenes, capacitación, Sanofi">
@endsection

@extends('users_pages.master')
@section('body')
<!-- Home sin login -->
         <div class="row pad-left" id="presentacion">

            <div class="col s12 l12" style="padding-left: 10%; padding-right: 10%;" >

               <h3 class="negro" style="text-transform: none !important " ><center>  Puede ponerse en contacto con nosotros vía telefónica:<br><br>
01 800 99 90 977<br><br>
Con horario de lunes a viernes de 9am a 6 pm y sábados de 9am a 3pm<br><br></center>

Favor de tomar nota que este formulario de contacto NO deberá ser usado para el reporte de situaciones de salud, notificaciones de efectos adversos o para la generación de preguntas 
ya sea técnicas o médicas relacionadas con productos de Sanofi.<br><br> En estos casos, usted deberá contactar a su médico de cabecera. Si usted es profesional de la salud y desea reportar 
un evento adverso, en el cual esté relacionado productos de Sanofi con paciente a su cargo, favor de emplear el procedimiento local de farmacovigilancia. fv-imed@sanofi.com <br><br>Si usted 
es paciente, por favor tome nota que Sanofi no proveerá consejos medicos ni recomendaciones de salud. Por lo cual lo invitamos a que consulte a su médico.<br><br> Para mayor información 
visite <a href="http://www.sanofi.com.mx/">www.sanofi.com.mx</a> <br><br> <center>Equipo Academia Médico ConSentido</center> </h3>

                <div class="row sesion">
                    <!-- <div class="col s12 l6 btnAcademiaMobi">
                        <a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Inicie_Sesion'});" href="#modal1" class="modal-trigger btnAcademia"
                        >INICIE SESIÓN <span class="icon-sesion iconbtn"></span></a>
                    </div> -->
                <div class="col s12 l6 btnAcademiaMobi">

                  @if(isset($ascription))
                    <!-- <a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Registrarse'});" href="{{ route('show.register.form.pharmacy', $ascription->slug)}}" class="btnAcademia"> REGÍSTRESE <span class="icon-registrese iconbtn"></span></a> -->
                  @else
                    <!-- <a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Registrarse'});" href="{{ route('register')}}" class="btnAcademia"> REGÍSTRESE <span class="icon-registrese iconbtn"></span></a> -->
                  @endif

               </div>
                </div>
                <!-- <div class="row sesion hide-on-med-and-down">
                    <div class="col s12 l6">
                  <a href="#!" class="btnAcademia">VER MÁS <span class="icon-mas iconbtn"></span></a>

               </div>
                <div class="col s12 l6 aprender-mas">


               </div>
                </div> -->

            </div>
             <!-- <div class="col s12 l6" id="img1">
               <img src="/img/img1.jpg" class="img-principal">
            </div> -->


         </div>

        @include('users_pages.courses.newest')

@stop
@section('extrajs')
<script>
  cambiarItem("home");
</script>

@stop
