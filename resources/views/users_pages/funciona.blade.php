@section('title')
Cómo funciona
@stop
@extends('users_pages.master')
@section('body')

<!-- Slider como funciona -->
        <div class="row pad-left3">
               <h2 class="recientes">¿Cómo funciona?</h2>
            <!-- Slideshow container -->
                <div class="row ">
                    <div class="card white slideshow-container col s12 l8">

                      <!-- Full-width slides/quotes -->
                      <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Registro
                          </span>
                        <p class="text-funciona">Ingrese a la página web www.paecmexico.com regístrese con el folio único indicado en la invitación al programa. Con esto, usted creará una nueva cuenta y así podrá tener acceso a los beneficios del curso.<br><br>Es necesario contar previamente con una dirección personal de e-mail.<br><br>Sólo está permitido una dirección de correo por usuario, a las personas identificadas con un doble registro se les permitirá el acceso sólo con una cuenta que será considerada como única.</p>
                        </div>

                      </div>

                    <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            CLAVE ÚNICA
                          </span>
                        <p class="text-funciona">Al completar el formato de registro, deberá proporcionar un nombre de usuario y contraseña de su elección para ser identificado dentro del Programa, los cuales no deben sobrepasar los 10 caracteres.</p>
                        </div>

                      </div>

                    <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Confirmación
                          </span>
                        <p class="text-funciona">El sistema le indicará que su registro se ha llevado a cabo con éxito.<br><br>Usted puede solicitar en cualquier momento el nombre de usuario y la contraseña con que se registró dando clic en la sección Inicio, y a continuación en Olvidé mi nombre de usuario y contraseña.</p>
                        </div>

                      </div>

                    <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Página web
                          </span>
                        <p class="text-funciona">Una vez registrado podrá ingresar a la página utilizando su nombre de usuario y contraseña seleccionados.<br><br>Esto le permitirá acceder tanto al material de estudio disponible en nuestra sección Módulos, como a las Evaluaciones.<br><br>La información sobre los ponentes y la duración de cada módulo podrá ser consultada en la sección de Expertos y Calendario, respectivamente.</p>
                        </div>

                      </div>

                    <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            El programa
                          </span>
                        <p class="text-funciona">El Programa se compone de varios módulos, cada uno de un mes de duración. Al inicio del curso se realizará un examen diagnóstico que no tendrá efectos en el resultado, pues funcionará como punto base para comparar la evaluación de cada participante.<br><br>Para poder ver los resultados, será necesario consultar la sección Evaluaciones. Es importante resaltar que el material de estudio sólo podrá descargarse en el periodo asignado.</p>
                        </div>

                      </div>

                    <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Evaluaciones
                          </span>
                        <p class="text-funciona">Para finalizar cada módulo será necesario completar una evaluación que estará disponible durante la última semana del mes, las 24 horas del día.<br><br>Al concluir el examen se mostrará el número de respuestas correctas y la calificación adquirida.<br><br>Es importante que consulte las fechas en la sección Calendario, ya que sólo se podrá presentar el examen en el periodo establecido, no habrá períodos extraordinarios.</p>
                        </div>

                      </div>

                    <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Calificaciones
                          </span>
                        <p class="text-funciona">Las calificaciones de cada módulo se mostrarán de manera inmediata al concluir el examen.<br><br>El sistema brinda la posibilidad de realizar por segunda vez el examen con la finalidad de mejorar la calificación, esto sólo podrá efectuarse si el usuario da clic en la opción Realizar nuevamente que aparecerá después de concluir la evaluación y obtener el grado final.</p>
                        </div>

                      </div>

                    <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            E-mailings
                          </span>
                        <p class="text-funciona">Usted recibirá comunicados vía e-mailing de manera periódica con relación al Programa, por lo que le solicitamos que revise con frecuencia el correo electrónico que utilizó durante el registro y verífique, si es necesario, la carpeta de correo no deseado.</p>
                        </div>

                      </div>

                    <div class="mySlides row">
                        <div class="col s3 center">
                            <img src="{{ asset('img/img1.JPG')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Servicio de soporte técnico
                          </span>
                        <p class="text-funciona">Si tiene problemas para navegar en la página no dude en contactar a nuestro equipo de servicio técnico, que le brindará atención de lunes a viernes de 9 a 18 horas y sábados de 9 a 14 horas, a través de la línea 01 800 2867 532 o mediante el correo electrónico soporte@paecmexico.com</p>
                        </div>

                      </div>


                    </div>
                    
                    <div class="dot-container col s12 l4">
                      <span class="dot"  onclick="currentSlide(1)">Registro</span><br>
                      <span class="dot"  onclick="currentSlide(2)">Clave única</span> <br>
                      <span class="dot" onclick="currentSlide(3)">Confirmación</span><br>
                      <span class="dot"  onclick="currentSlide(4)">Página web</span><br>
                      <span class="dot"  onclick="currentSlide(5)">El programa</span><br>
                      <span class="dot"  onclick="currentSlide(6)">Evaluaciones</span><br>
                      <span class="dot"  onclick="currentSlide(7)">Calificaciones</span><br>
                      <span class="dot"  onclick="currentSlide(8)">E-mailings</span><br>
                      <span class="dot"  onclick="currentSlide(9)">Servicio de soporte técnico</span><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 l3 leer-mas prev">
                         <hr class="line3"/>
                        <a class="" onclick="plusSlides(-1)">anterior</a>
                     </div>
                    <div class="col s6 l3 offset-l3 leer-mas next">
                        <a class="" onclick="plusSlides(1)">siguiente</a>
                         <hr class="line3"/>
                     </div>

                </div>

          </div>
@stop

@section('extrajs')

<script>
  cambiarItem("funciona");
</script>
@stop
