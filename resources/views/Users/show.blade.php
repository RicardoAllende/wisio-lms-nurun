@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Usuario</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li class="active">
            <a href="{{ route('users.index') }}">Usuarios</a>
        </li>
        <li>
            {{ $user->full_name }}
        </li>
    </ol>
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
                <div class="col-sm-3">
                    <div class="text-center">
                        <img alt="image" class="img-circle m-t-xs img-responsive" src="https://image.flaticon.com/icons/png/512/149/149071.png">
                        <div class="m-t-xs font-bold">Usuario</div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="widget-head-color-box navy-bg p-lg">
                        <h2>
                            {{ $user->firstname }} {{ $user->lastname }}
                        </h2>
                        <ul class="list-unstyled m-t-md">
                            <li>
                                <span class="fa fa-th-large m-r-xs"></span>
                                <label>Adscripción:</label>
                                {{ $user->ascription->name }}
                            </li>
                            <li>
                                <span class="fa fa-th-large m-r-xs"></span>
                                <label>Sexo:</label>
                                {{ $user->gender }}
                            </li>
                            <li>
                                <span class="fa fa-envelope m-r-xs"></span>
                                <label>Email:</label>
                                {{ $user->email }}
                            </li>
                            <li>
                                <span class="fa fa-home m-r-xs"></span>
                                <label>Dirección:</label>
                                {{ $user->city }}, {{ $user->zip }}, {{ $user->address }}
                            </li>
                            <li>
                                <span class="fa fa-mobile-phone m-r-xs"></span>
                                <label>Teléfono móvil:</label>
                                {{ $user->mobile_phone }}
                            </li>
                            <li>
                                <span class="fa fa-address-card-o m-r-xs"></span>
                                <label>Cédula profesional:</label>
                                {{ $user->professional_license }}
                            </li>
                            <li>
                                <span class="fa fa-plus-circle m-r-xs"></span>
                                <label>Tipo de consulta</label>
                                {{ $user->consultation_type }}
                            </li>
                            @if($user->specialty != null)
                            <li>
                                <span class="fa fa-book m-r-xs"></span>
                                <label>Especialidad: </label>
                                {{ $user->specialty->name }}
                            </li>
                            @endif
                        </ul>
                    </div> 
                </div>
            </div>

            <h3>Completar cursos</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>@php $i=1; @endphp
                    @foreach($user->ascription->courses as $course)
                        <tr>
                            <td><a href="{{route('courses.show', $course->id)}}">{{ $i }}</a></td>@php $i++; @endphp
                            <td><a href="{{route('courses.show', $course->id)}}">{{ $course->name }}</a></td>
                            <td>
                            @if($user->completedCourses->contains($course->id))
                                Terminado con: {{ $user->scoreInCourse($course->id) }}
                            @else
                                Aún no se ha terminado
                            @endif
                            </td>
                            <td>
                                <a href="{{ route('complete.course', [$user->id, $course->id]) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Completar curso</a>
                            </td>
                        </tr>    
                    @endforeach
                    </tbody>
                </table>
            </div>          

            <div class="clearfix"></div>
                
        </div>

        </div>
      </div>
	</div>
</div>
@endsection