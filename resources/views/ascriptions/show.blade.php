@extends('layouts.app')

@section('title','Adscripción '.$ascription->name)
@section('cta')
  <a href="{{ action('AscriptionsController@edit', $ascription->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Editar adscripción</a>
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
                    <div class="col-sm-8">
                        <h3><strong>Nombre: {{ $ascription->name }} </strong></h3>
                        <p>Descripción: {{ $ascription->description }} </p>
                    </div>
                    <div class="clearfix">
                        Estado: {{ ($ascription->status == 1)? 'disponible' : 'no disponible' }}
                    </div>
                </div>

            @if ($ascription->courses->count() > 0)
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
                                <td><a href="{{ action('CoursesController@show', $course->id) }}">{{ $i }}</a></td>
                                <td><a href="{{ action('CoursesController@show', $course->id) }}">{{ $course->name }}</a></td>
                                <td>{{$course->start_date}}</td>
                                <td>{{$course->end_date}}</td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE','route'=>['ascriptions.destroy',$course->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
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
                <h3><strong>Esta adscripción aún no tiene cursos asignados, ¿desea agregar alguno?</strong></h3><br>
                <a href="{{route('add.courses.to.ascription', $ascription->id)}}" class="btn btn-info">Asignar curso ya existente</a>&nbsp;
                <a href="{{ route('create.course.for.ascription', $ascription->id) }}" class="btn btn-info">Crear curso</a>
            @endif
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