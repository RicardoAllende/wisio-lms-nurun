@section('title')
Curso {{ $course->name }}
@stop
@extends('users_pages.master')
@section('body')


<div class="row pad-left3">
          <div class="col s6 l9">
             <hr class="line"/>
          </div>
          <div class="col s6 l3">
             <h2 class="recientes">cursos recomendados</h2>
          </div>
          <div class="col s12 l4 ">
             <div class="card z-depth-0 white ">
                <div class="card-content mods">
                   <span class="categoria-academia">Cardiologia </span>
                  <span class="icon-cardiologia iconcourse"></span>
                   <div class="titulo-academia2">Conferencia: Genoma Humano</div>
                    <div class="modulos">7 módulos</div>
                    <div  class="moduloslista valign-wrapper">
                      <ol>
                          <li> Prevalencia y diagnóstico</li>
                          <li> Opciones terapéuticas</li>
                          <li> Insomnio en la mujer</li>
                          <li> Paciente con insomnio</li>
                          <li> Comorbilidades psiquiátricas</li>
                          <li> Caso clínico</li>
                          <li> Webcast</li>
                        </ol>
                    </div >
                   <div class="leer-masmodulos">
                      <a href="#!">Leer Todo</a>
                       <hr class="line3"/>
                   </div>
                </div>
             </div>
          </div>
            <div class="col s12 l4 ">
             <div class="card z-depth-0 white">
                <div class="card-content mods">
                   <span class="categoria-academia">Cardiologia </span>
                  <span class="icon-cardiologia iconcourse"></span>
                   <div  class="titulo-academia2">Conferencia: Genoma Humano</div >
                    <div  class="modulos">9 módulos</div >
                    <div  class="moduloslista valign-wrapper">
                      <ol >
                          <li> Prevalencia y diagnóstico</li>
                          <li> Opciones terapéuticas</li>
                          <li> Insomnio en la mujer</li>
                          <li> Paciente con insomnio</li>
                          <li> Comorbilidades psiquiátricas</li>
                          <li> Caso clínico</li>
                          <li> Webcast</li>
                          <li> Caso clínico</li>
                          <li> Webcast</li>
                        </ol>
                    </div >
                   <div class="leer-masmodulos">
                      <a href="#!">Leer Todo</a>
                       <hr class="line3"/>
                   </div>
                </div>
             </div>
          </div>
            <div class="col s12 l4 ">
             <div class="card z-depth-0 white">
                <div class="card-content mods">
                   <span class="categoria-academia">Cardiologia </span>
                  <span class="icon-cardiologia iconcourse"></span>
                   <div  class="titulo-academia2">Conferencia: Genoma Humano</div >
                    <div  class="modulos">5 módulos</div >
                    <div  class="moduloslista valign-wrapper">
                      <ol>
                          <li> Prevalencia y diagnóstico</li>
                          <li> Opciones terapéuticas</li>
                          <li> Insomnio en la mujer</li>
                          <li> Paciente con insomnio</li>
                          <li> Comorbilidades psiquiátricas</li>

                        </ol>
                    </div >
                   <div class="leer-masmodulos">
                      <a href="#!">Leer Todo</a>
                       <hr class="line3"/>
                   </div>
                </div>
             </div>
          </div>
       </div>


@include('users_pages.courses.newest')
@stop
