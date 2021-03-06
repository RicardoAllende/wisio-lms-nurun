@extends('layouts.app')

@section('title','Adscripción: '.$ascription->name)
@section('cta')
<a href="{{ route('ascriptions.edit', $ascription->id) }}" class="btn btn-primary"><i class='fa fa-edit'></i>Editar adscripción</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('ascriptions.index') }}"> Adscripciones</a>
        </li>
        <li class="active" >
            {{ $ascription->name }}
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de la adscripción</h5>
            </div>
            <div class="ibox-content">
                <div class="contact-box">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="m-t-xs img-responsive" src="{{ $ascription->getMainImgUrl() }}">
                            <!--<div class="m-t-xs font-bold">Usuario</div>-->
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <h3><strong>Nombre: {{ $ascription->name }} </strong></h3>
                        <p>Slug: {{ $ascription->slug }}</p>
                        <p>Usuarios inscritos: {{ $ascription->users()->count() }}</p>
                        <p>Cursos: {{ $ascription->courses()->count() }}</p>
                        <p>Descripción: {{ $ascription->description }} </p>
                        <p>Estado: {{ ($ascription->enabled == 1)? 'disponible' : 'no disponible' }}</p>
                        @if($ascription->hasCalendar())<p><a target="_blank" href="{{ $ascription->calendarUrl() }}">Calendario</a></p>@endif
                    </div>
                    <div class="clearfix">
                    </div>
                </div>

            @if ($ascription->courses()->count() > 0)
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
                            @foreach($ascription->courses as $course) 
                                <tr>
                                <td><a href="{{ route('courses.show', $course->id) }}">{{ $i }}</a></td>
                                <td><a href="{{ route('courses.show', $course->id) }}">{{ $course->name }}</a></td>
                                <td>{{$course->start_date}}</td>
                                <td>{{$course->end_date}}</td>
                                <td>
                                    <a href="{{ route('dissociate.course.of.ascription', [$course->id, $ascription->id]) }}" class="btn btn-danger btn-round">
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
                <h3><strong>Esta adscripción aún no tiene cursos asignados, ¿desea agregar alguno?</strong></h3><br>
            @endif
                <a href="{{ route('list.courses.for.ascription', $ascription->id) }}" class="btn btn-info">Agregar cursos ya existentes</a>&nbsp;
                <a href="{{ route('course.form.for.ascription', $ascription->id) }}" class="btn btn-info">Crear curso</a>
                
            </div>
        </div>
      </div>
	</div>
</div>
@endsection
@section('scripts')
<script src="/js/sweetalert2.min.js"></script>
<script src="/js/method_delete_f.js"></script>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection