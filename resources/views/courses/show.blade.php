@extends('layouts.app')

@section('title','Curso '.$course->name)
@section('cta')
  <a href="/courses/{{ $course->id }}/edit" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Curso</a>
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
                    <!--<div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="m-t-xs img-responsive" src="">
                        </div>
                    </div>-->
                    <div class="col-sm-8">
                        <h3><strong>Nombre: {{ $course->name }}</strong></h3>
                        <p> {{ $course->description }}</p>
                    </div>
                    <div class="clearfix">
                        Fecha de inicio: {{$course->date_start}} <br>
                        Fecha de fin: {{$course->date_end}}
                    </div>
                </div>
                
                @if ($course->modules->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Módulo</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha de fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($course->modules as $module) 
                                <tr>
                                <td><a href="{{ action('ModulesController@show', $module->id) }}">{{ $i }}</a></td>
                                <td><a href="{{ action('ModulesController@show', $module->id) }}">{{ $module->name }}</a></td>
                                <td>{{ $module->start_date }}</td>
                                <td>{{ $module->end_date }}</td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE','route'=>['ascriptions.destroy',$module->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
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
                    <h3><strong>Este curso aún no tiene módulos asignados, ¿desea agregar alguno?</strong></h3><br>
                    <a href="" class="btn btn-info">Asignar módulo ya existente</a>&nbsp;
                    <a href="{{ action('ModulesController@create') }}" class="btn btn-info">Crear módulo</a>
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