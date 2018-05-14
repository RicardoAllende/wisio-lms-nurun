@extends('layouts.app')

@section('title','Curso '.$course->name)
@section('cta')
  <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Curso</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="widget-head-color-box navy-bg p-lg text-center">
                <div class="m-b-md">
                <h2 class="font-bold no-margins">
                    {{$course->name}}
                </h2>
                    <small>Nombre del curso</small>
                </div>
                <img src="{{$course->getMainImgUrl()}}" width="50%" height="50%" class="m-b-md" alt="Imagen del curso">
                <div>
                    <span>{{ $course->users->count() }} inscritos</span> |
                    <span>{{ $approved }} terminaron el curso</span> |
                    <span>{{ $course->modules->count() }} módulos</span>
                </div>
            </div>
            <div class="widget-text-box">
                <h4 class="media-heading">Descripción del curso</h4>
                <p>{{$course->description}}. Fecha de inicio: {{ $course->start_date }}, Fecha de término: {{ $course->end_date }}</p>
            </div>

            <div class="ibox float-e-margins">
                
                <h3>Información de los módulos</h3>
                @if ($course->hasModules())
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
                @endif
                    <a href="{{ route('list.modules.for.course', $course->id) }}" class="btn btn-info btn-round">Asignar módulo ya existente</a>&nbsp;
                    <a href="{{ route('module.form.for.course', $course->id) }}" class="btn btn-info btn-round">Crear módulo</a>

            </div>
        </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection