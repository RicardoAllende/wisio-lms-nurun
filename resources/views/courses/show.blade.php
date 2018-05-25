@extends('layouts.app')

@section('title','Curso '.$course->name)
@section('cta')
  <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Editar Curso</a>
  <a href="{{ route('list.users.for.course', $course->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Inscribir usuarios</a>
  <!--<a href="" class="btn btn-primary "><i class='fa fa-edit'></i>Agregar manual</a>-->
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('courses.index') }}"> Cursos</a>
        </li>
        <li class="active" >
            {{ $course->name }}
        </li>
    </ol>
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
                                {{$course->name}}
                            </h2>
                            <small>{{ ($course->category != null) ? "Categoría ".$course->category->name : '' }}</small>
                        </div>
                        <img src="{{$course->getMainImgUrl()}}" width="30%" height="30%" class="m-b-md" alt="Imagen del curso">
                    </div>
                    <div class="col-lg-6"><br><br>
                        <p>Estudiantes inscritos: {{ $course->users->count() }}</p>
                        <p>{{ $course->modules->count() }} módulos</p>
                        <p>Slug: {{ $course->slug }}</p>
                        <p>Evaluaciones finales: {{ $course->finalEvaluations()->count() }}</p>
                        <h4 class="media-heading">Descripción del curso</h4>
                        <p>{{$course->description}}.</p>
                        <p>Fecha de inicio: {{ $course->start_date }}</p>
                        <p> Fecha de término: {{ $course->end_date }}</p>
                    </div>
                </div>
                        
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
                                <td><a href="{{ route('modules.show', $module->id) }}">{{ $i }}</a></td>
                                <td><a href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</a></td>
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
                    <a href="{{ route('modules.create').'?course_id='.$course->id }}" class="btn btn-info btn-round">Crear módulo</a>
            </div>
        </div>
	</div>
</div>
@endsection