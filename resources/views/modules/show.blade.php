@extends('layouts.app')

@section('title','Módulo '.$module->name)
@section('cta')
  <a href="{{action('ModulesController@edit', $module->id)}}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Módulo</a>
  <a href="{{ route('list.experts.for.module', $module->id) }}" class="btn btn-primary" >Administrar Expertos</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">

            <div class="widget-head-color-box navy-bg p-lg text-center">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="m-b-md">
                            <h2 class="font-bold no-margins">
                                {{$module->name}}
                            </h2>
                            <small>Nombre del módulo</small>
                        </div>
                        <img src="{{$module->getMainImgUrl()}}" width="30%" height="30%" class="m-b-md" alt="Imagen del módulo">
                        <div>
                            <span>{{ $module->evaluations->count() }} inscritos</span> |
                            <span>{{ $timesPassed }} médicos terminaron el curso</span> |
                            <span>{{ $module->attachments->count() }} archivos adjuntos</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h2>Expertos</h2><br>  
                        @php $i=1; @endphp
                        @foreach($module->experts as $expert) 
                            <h4>{{ $i }} {{ $expert->name }}</h4>
                            @php $i++; @endphp
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="widget-text-box">
                <h4 class="media-heading">Descripción del Módulo</h4><br>
                @if($module->hasCourse())<h3><a href="{{ route('courses.show', $module->course->id) }}" >Curso: {{ $module->course->name }}</a></h3>@endif
                <p>{{$module->description}}. <br>Fecha de inicio: {{ $module->start_date }} || Fecha de término: {{ $module->end_date }}</p>
            </div>

            <div class="ibox float-e-margins"><br>
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Evaluaciones</h3>
                        @if ($module->hasEvaluations())
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Evaluación</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
                                        @foreach($module->evaluations as $evaluation) 
                                            <tr>
                                            <td><a href="{{ action('EvaluationsController@show', $evaluation->id) }}">{{ $i }}</a></td>
                                            <td><a href="{{ action('EvaluationsController@show', $evaluation->id) }}">{{ $evaluation->name }}</a></td>
                                            <td>{{ ($evaluation->type == 'd')? 'Diagnóstica' : 'Final' }}</td>
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
                    </div>
                    <div class="col-lg-6">
                        <h3>Recursos</h3>
                        @if($module->hasResources())
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Recurso</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
                                        @foreach($module->resources as $resource) 
                                            <tr>
                                            <td><a href="{{ action('ResourcesController@show', $resource->id) }}">{{ $i }}</a></td>
                                            <td><a href="{{ action('ResourcesController@show', $resource->id) }}">{{ $resource->type }}</a></td>
                                            <td>{{ ($evaluation->type == 'd')? 'Diagnóstica' : 'Final' }}</td>
                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else

                        @endif
                        <a href="" class="btn btn-info btn-round" >Agregar recursos</a>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection