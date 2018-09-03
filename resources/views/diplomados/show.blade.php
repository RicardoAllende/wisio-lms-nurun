@extends('layouts.app')

@section('title','Curso '.$diploma->name)
@section('cta')
    <a href="{{ route('diplomas.edit', $diploma->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Editar Diplomado</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('diplomas.index') }}"> Diplomados</a>
        </li>
        <li class="active" >
            {{ $diploma->name }}
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="widget-head-color-box navy-bg p-lg text-center">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="m-b-md">
                            <h2 class="font-bold no-margins">
                                {{$diploma->name}}
                            </h2>
                        </div>
                        <img src="{{$diploma->getMainImgUrl()}}" width="30%" height="30%" class="m-b-md" alt="Imagen del curso">
                    </div>
                    <div class="col-lg-6"><br><br>
                        <p>Promedio mínimo de los cursos anteriores: {{ $diploma->minimum_previous_score }}</p>
                        <p>Calificación mínima del diplomado: {{ $diploma->minimum_score }}</p>
                        <p>Estudiantes inscritos: {{ $diploma->users()->count() }}</p>
                        <p>Slug: {{ $diploma->slug }}</p>
                        <h4 class="media-heading">Descripción del curso</h4>
                        <p>{!! $diploma->description !!}</p>
                    </div>
                </div>
                
                    
            </div>
            <div class="ibox float-e-margins"><br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Curso</th>
                            <th>Créditos</th>
                            <th>Promedio Mínimo</th>
                            <th>Acciones</th>
                            </tr>
                        </thead>
                        <h2>Escoga aquí los cursos necesarios para poder realizar el diplomado</h2>
                        <br>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($courses as $course) 
                                <tr>
                                <td><a href="{{ route('courses.show', $course->id) }}">{{ $i }}</a></td>
                                <td><a href="{{ route('courses.show', $course->id) }}">{{ $course->name }}</a></td>
                                <td>{{ $course->credits }}</td>
                                <td>{{ $course->minimum_score }}</td>
                                <td>
                                @if($diploma->hasCourseDependency($course->id))
                                    <a href="{{ route('detach.course.from.diploma', [$diploma->id, $course->id]) }}" class="btn btn-danger btn-round">
                                        Quitar
                                    </a>
                                @else
                                    <a href="{{ route('attach.course.to.diploma', [$diploma->id, $course->id]) }}" class="btn btn-primary btn-round">
                                        Agregar
                                    </a>
                                @endif
                                </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                
        </div>
	</div>
</div>
@endsection