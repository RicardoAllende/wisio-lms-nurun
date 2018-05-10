@extends('layouts.app')

@section('title','Módulo '.$module->name)
@section('cta')
  <a href="{{action('ModulesController@edit', $module->id)}}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Módulo</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">

            <div class="widget-head-color-box navy-bg p-lg text-center">
                <div class="m-b-md">
                <h2 class="font-bold no-margins">
                    {{$module->name}}
                </h2>
                    <small>Nombre del módulo</small>
                </div>
                <img src="{{$module->img_url()}}" width="15%" height="15%" class="m-b-md" alt="Imagen del módulo">
                <div>
                    <span>{{ $module->evaluations->count() }} inscritos</span> |
                    <span>{{ $timesPassed }} médicos terminaron el curso</span> |
                    <span>{{ $module->attachments->count() }} archivos adjuntos</span>
                </div>
            </div>
            <div class="widget-text-box">
                <h4 class="media-heading">Descripción del Módulo</h4>
                <p>{{$module->description}}. Fecha de inicio: {{ $module->start_date }}, Fecha de término: {{ $module->end_date }}</p>
            </div>

            <div class="ibox float-e-margins">
                <h3>Evaluaciones</h3>
                @if ($module->hasEvaluations())
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Evaluación</th>
                                <th>Tipo</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha de fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($module->evaluations as $evaluation) 
                                <tr>
                                <td><a href="{{ action('EvaluationsController@show', $evaluation->id) }}">{{ $i }}</a></td>
                                <td><a href="{{ action('EvaluationsController@show', $evaluation->id) }}">{{ $evaluation->name }}</a></td>
                                <td>{{ ($evaluation->type == 'd')? 'Diagnóstica' : 'Final' }}</td>
                                <td>{{$evaluation->start_date}}</td>
                                <td>{{$evaluation->end_date}}</td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE','route'=>['evaluations.destroy',$evaluation->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                        <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
                                    {!! Form::close() !!}
                                </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <h3><strong>Este Módulo aún no tiene evaluaciones asignadas, ¿desea agregar alguna?</strong></h3><br>
                @endif

                <a href="{{ action('EvaluationsController@create') }}?module_id={{$module->id}}" class="btn btn-info text-left">Crear evaluación</a><br><br><hr><hr>

                <h3>Cursos</h3>
                @if ($module->hasCourses())
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Curso</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($module->courses as $course) 
                                <tr>
                                <td><a href="{{ action('CoursesController@show', $course->id) }}">{{ $i }}</a></td>
                                <td><a href="{{ action('CoursesController@show', $course->id) }}">{{ $course->name }}</a></td>
                                <td>{{$course->start_date}}</td>
                                <td>{{$course->end_date}}</td>
                                <td>
                                    <a href="{{ route('dissociate.module.of.course', [$module->id, $course->id]) }}" class="btn btn-danger btn-round">
                                        Quitar
                                    </a>
                                </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h3><strong>Este módulo aún no ha sido asignado a ningún curso</strong></h3><br>
            @endif
                <a href="{{ route('courses.index') }}" class="btn btn-info text-right" >Mostrar lista de cursos</a>

            </div>
        </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection