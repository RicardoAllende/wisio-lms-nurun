@extends('layouts.app')

@section('title','Reporte de usuario')

@section('subtitle')
    <ol class="breadcrumb">
        <li>Reportes</li>
        <li><a href="{{route('list.users.report')}}"></a> Usuarios</li>
        <li>Usuario: {{ $user->firstname }} {{ $user->lastname }} </li>
    </ol>
@endsection


@section('cta')

@endsection
    
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de Usuario</h5>
                
            </div>

		<div class="contact-box">
            
            <div class="row">
                <div class="col-sm-6">
                    <h3><strong>Nombre: {{ $user->firstname }} {{ $user->lastname }}  </strong></h3>
                    <p>Cédula profesional: {{ $user->professional_license }} </p>
                    <p>Fecha de nacimiento: {{ $user->birthday }} </p>
                    <p>@if($user->gender != null)<span class="{{ ($user->gender == 'M') ? 'fa fa-male' : 'fa fa-female' }}"></span>@endif </p>
                    <p>Teléfono móvil: {{ $user->mobile_phone }}</p>
                    <p>Tipo de consulta: {{ $user->consultation_type }} </p>
                    <p>Fecha de último acceso {{ $user->last_access }}</p>
                </div>
                <div class="col-sm-6">
                    
                    <p>Ciudad: {{ $user->city }} </p>
                    <p>Estado: {{ $user->state }} </p>
                    <p>Dirección: {{ $user->address }} </p>
                </div>
            </div>
            <hr/><hr/>
            @if($user->hasCourses())
            <h3>Detalle de inscripciones a cursos</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Curso</th>
                            <th>Calificación mínima aprobatoria</th>
                            <th>Calificación obtenida</th>
                            <th>Última actualización</th>
                        </tr>
                    </thead>
                    <tbody>@php $i=1; @endphp
                        @foreach($user->courses as $course)
                        <tr>
                            <td><a href="{{route('courses.show', $course->id)}}">{{ $i }}</a></td>@php $i++; @endphp
                            <td><a href="{{route('courses.show', $course->id)}}">{{ $course->name }}</a></td>
                            <td>{{ $course->minimum_score }}</td>
                            <td>{{ ($course->pivot->score == "") ? "Aún sin calificar" : $course->pivot->score }}</td>
                            <td>{{ $course->pivot->updated_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <div class="clearfix"></div>
                
        </div>

        </div>
      </div>
	</div>
</div>
@endsection