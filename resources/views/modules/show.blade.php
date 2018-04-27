@extends('layouts.app')

@section('title','Módulo '.$module->name)
@section('cta')
  <a href="{{action('ModulesController@edit', $module->id)}}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Módulo</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Datos de Curso</h5>
                </div>
                <div class="contact-box">
                    <div class="col-sm-8">
                        <h3><strong>Nombre: {{ $module->name }}</strong></h3>
                        <p> {{ $module->description }}</p>
                    </div>
                    <div class="clearfix">
                        Fecha de inicio: {{$module->date_start}} <br>
                        Fecha de fin: {{$module->date_end}}
                    </div>
                </div>
                
                @if ($module->evaluations->count() > 0)
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
                                    {!! Form::open(['method'=>'DELETE','route'=>['ascriptions.destroy',$evaluation->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
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
                    <a href="{{ action('EvaluationsController@create') }}" class="btn btn-info">Crear evaluación</a>
                @endif

            </div>
        </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection