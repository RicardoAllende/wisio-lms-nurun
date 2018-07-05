@section('title')
Cómo funciona
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.funciona', $ascription->slug) }}" class="breadcrumb">Como funciona</a>
@stop

@section('body')

<!-- Slider como funciona -->
        <div class="row pad-left3">
               <h1 class="tits">¿Cómo funciona?</h1>
            <!-- Slideshow container -->
                <div class="row ">
                    <div class="card white slideshow-container col s12 l8">

                      <!-- Full-width slides/quotes -->
                      <div class="mySlides">
                        <div class="row hide-on-med-and-down">
                          <div class="col s3 center">
                              <img src="{{ asset('img/funciona/registro.png')}}" class="responsive-img">
                          </div>
                          <div class="col s9">
                            <span class="titulo-funciona">
                              Registro
                            </span>
                          <p class="text-funciona">Ingrese sus datos y comience a hacer uso de las herramientas que Médico ConSentido de Sanofi tiene preparadas para usted.
                            <br><br>Registro – Es necesario contar previamente con una cuenta de correo personal para crear una que le permita el acceso a los cursos de Academia.
                            <br><br>Se permite sólo una cuenta por usuario.
                          </p>
                          </div>
                        </div>

                        <div class="row hide-on-large-only">
                          <h3 class="titulo-funciona">Registro</h3>
                          <div class="col s4 center">
                              <img src="{{ asset('img/funciona/registro.png')}}" class="responsive-img">
                          </div>
                          <div class="col s8">
                          <p class="textFuncionaMob">Ingrese sus datos y comience a hacer uso de las herramientas que Médico ConSentido de Sanofi tiene preparadas para usted.</p>
                          </div>
                          <div class="col s12">
                          <p class="text-funciona">Registro – Es necesario contar previamente con una cuenta de correo personal para crear una que le permita el acceso a los cursos de Academia.
                          <br><br>Se permite sólo una cuenta por usuario.

                          </p>
                          </div>
                        </div>


                      </div>

                    <div class="mySlides">
                      <div class="row hide-on-med-and-down">
                        <div class="col s3 center">
                            <img src="{{ asset('img/funciona/clave-unica.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            CLAVE ÚNICA
                          </span>
                        <p class="text-funciona">Una vez completado el registro, deberá proporcionar usuario y contraseña menor a 10 caracteres. </p>
                        </div>

                      </div>
                      <div class="row hide-on-large-only">
                        <h3 class="titulo-funciona">CLAVE ÚNICA</h3>
                        <div class="col s4 center">
                            <img src="{{ asset('img/funciona/clave-unica.png')}}" class="responsive-img">
                        </div>
                        <div class="col s8">
                        <p class="textFuncionaMob">Una vez completado el registro</p>
                        </div>
                        <div class="col s12">
                        <p class="text-funciona"> Deberá proporcionar usuario y contraseña menor a 10 caracteres. </p>
                        </div>
                      </div>
                    </div>

                    <div class="mySlides">
                      <div class="row hide-on-med-and-down">
                        <div class="col s3 center">
                            <img src="{{ asset('img/funciona/confirmacion.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Confirmación
                          </span>
                        <p class="text-funciona">Queda registrado exitosamente.<br><br> Puede consultar su registro nuevamente en Olvidé mi nombre de usuario y contraseña.</p>
                        </div>

                      </div>
                      <div class="row hide-on-large-only">
                        <h3 class="titulo-funciona">Confirmación</h3>
                        <div class="col s4 center">
                            <img src="{{ asset('img/funciona/confirmacion.png')}}" class="responsive-img">
                        </div>
                        <div class="col s8">
                        <p class="textFuncionaMob">Queda registrado exitosamente.</p>
                        </div>
                        <div class="col s12">
                        <p class="text-funciona">Puede consultar su registro nuevamente en Olvidé mi nombre de usuario y contraseña.</p>
                        </div>
                      </div>
                    </div>

                    <div class="mySlides">
                      <div class="row hide-on-med-and-down">
                        <div class="col s3 center">
                            <img src="{{ asset('img/funciona/web.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Página web
                          </span>
                        <p class="text-funciona">Con su usuario y contraseña puede comenzar a utilizar el material de estudio disponible en Módulos y Evaluaciones.</p>
                        </div>

                      </div>
                      <div class="row hide-on-large-only">
                        <h3 class="titulo-funciona">Página web</h3>
                        <div class="col s4 center">
                            <img src="{{ asset('img/funciona/web.png')}}" class="responsive-img">
                        </div>
                        <div class="col s8">
                        <p class="textFuncionaMob">Con su usuario y contraseña</p>
                        </div>
                        <div class="col s12">
                        <p class="text-funciona">Puede comenzar a utilizar el material de estudio disponible en Módulos y Evaluaciones.</p>
                        </div>
                      </div>
                    </div>

                    <div class="mySlides">
                      <div class="row hide-on-med-and-down">
                        <div class="col s3 center">
                            <img src="{{ asset('img/funciona/programa.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            El programa
                          </span>
                        <p class="text-funciona">Módulos donde se realizan exámenes diagnóstico al inicio, y una evaluación completa al concluirlos.</p>
                        </div>

                      </div>
                      <div class="row hide-on-large-only">
                        <h3 class="titulo-funciona">El programa</h3>
                        <div class="col s4 center">
                            <img src="{{ asset('img/funciona/programa.png')}}" class="responsive-img">
                        </div>
                        <div class="col s8">
                        <p class="textFuncionaMob">Módulos</p>
                        </div>
                        <div class="col s12">
                        <p class="text-funciona">Donde se realizan exámenes diagnóstico al inicio, y una evaluación completa al concluirlos.</p>
                        </div>
                      </div>
                    </div>

                    <div class="mySlides">
                      <div class="row hide-on-med-and-down">
                        <div class="col s3 center">
                            <img src="{{ asset('img/funciona/evaluaciones.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Evaluaciones
                          </span>
                        <p class="text-funciona">Al finalizar cada módulo se llevará a cabo una evaluación que estará disponible las 24 horas del día.</p>
                        </div>

                      </div>
                      <div class="row hide-on-large-only">
                        <h3 class="titulo-funciona">Evaluaciones</h3>
                        <div class="col s4 center">
                            <img src="{{ asset('img/funciona/evaluaciones.png')}}" class="responsive-img">
                        </div>
                        <div class="col s8">
                        <p class="textFuncionaMob">Al finalizar cada módulo</p>
                        </div>
                        <div class="col s12">
                        <p class="text-funciona">Se llevará a cabo una evaluación que estará disponible las 24 horas del día.</p>
                        </div>
                      </div>
                    </div>

                    <div class="mySlides">
                      <div class="row hide-on-med-and-down">
                        <div class="col s3 center">
                            <img src="{{ asset('img/funciona/calificaciones.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Calificaciones
                          </span>
                        <p class="text-funciona">Las calificaciones se mostrarán inmeditamente al concluir el examen, y se brinda la posibilidad de presentarlo una segunda vez para mejorar la calificación.</p>
                        </div>

                      </div>
                      <div class="row hide-on-large-only">
                        <h3 class="titulo-funciona">Calificaciones</h3>
                        <div class="col s4 center">
                            <img src="{{ asset('img/funciona/calificaciones.png')}}" class="responsive-img">
                        </div>
                        <div class="col s8">
                        <p class="textFuncionaMob">Las calificaciones se mostrarán inmeditamente al concluir el examen</p>
                        </div>
                        <div class="col s12">
                        <p class="text-funciona">Y se brinda la posibilidad de presentarlo una segunda vez para mejorar la calificación.</p>
                        </div>
                      </div>
                    </div>

                    <div class="mySlides">
                      <div class="row hide-on-med-and-down">
                        <div class="col s3 center">
                            <img src="{{ asset('img/funciona/emailing.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            E-mailings
                          </span>
                        <p class="text-funciona">Recibirá comunicados vía E-mailing con información necesaria del programa.</p>
                        </div>

                      </div>
                      <div class="row hide-on-large-only">
                        <h3 class="titulo-funciona">E-mailings</h3>
                        <div class="col s4 center">
                            <img src="{{ asset('img/funciona/emailing.png')}}" class="responsive-img">
                        </div>
                        <div class="col s8">
                        <p class="textFuncionaMob">Recibirá comunicados vía E-mailing</p>
                        </div>
                        <div class="col s12">
                        <p class="text-funciona">Con información necesaria del programa.</p>
                        </div>
                      </div>
                    </div>

                    <div class="mySlides">
                      <div class="row hide-on-med-and-down">
                        <div class="col s3 center">
                            <img src="{{ asset('img/funciona/servicio-soporte.png')}}" class="responsive-img">
                        </div>
                        <div class="col s9">
                          <span class="titulo-funciona">
                            Servicio de soporte técnico
                          </span>
                        <p class="text-funciona">Si tiene problemas de navegación en el sitio puede contactar a soporte técnico de lunes a viernes de 9 a 18 horas y sábados de 9 a 14 horas, a través de la línea +52 55 548444 ext 4321 o al correo soporte@academia.mx</p>
                        </div>

                      </div>
                      <div class="row hide-on-large-only">
                        <h3 class="titulo-funciona">Servicio de soporte técnico</h3>
                        <div class="col s4 center">
                            <img src="{{ asset('img/funciona/servicio-soporte.png')}}" class="responsive-img">
                        </div>
                        <div class="col s8">
                        <p class="textFuncionaMob">Si tiene problemas de navegación en el sitio</p>
                        </div>
                        <div class="col s12">
                        <p class="text-funciona">Puede contactar a soporte técnico de lunes a viernes de 9 a 18 horas y sábados de 9 a 14 horas, a través de la línea +52 55 548444 ext 4321 o al correo soporte@academia.mx</p>
                        </div>
                      </div>
                    </div>


                    </div>
                    <div class="row hide-on-large-only">
                        <div class="col s6 l3 leer-mas prev">
                             <hr class="line3"/>
                            <a class="" onclick="plusSlides(-1)">anterior</a>
                         </div>
                        <div class="col s6 l3 offset-l3 leer-mas next">
                            <a class="" onclick="plusSlides(1)">siguiente</a>
                             <hr class="line3"/>
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
                <div class="row hide-on-med-and-down">
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
