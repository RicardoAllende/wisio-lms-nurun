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
                        <p>Usuarios inscritos: {{ $ascription->users->count() }}</p>
                        <p>Cursos: {{ $ascription->courses->count() }}</p>
                        <p>Descripción: {{ $ascription->description }} </p>
                        <p>Estado: {{ ($ascription->enabled == 1)? 'disponible' : 'no disponible' }}</p>
                        @if($ascription->hasCalendar())<p><a target="_blank" href="{{ $ascription->calendarUrl() }}">Calendario</a></p>@endif

                    </div>
                    <div class="clearfix">
                    </div>
                </div>

                @if($users->count() > 0)
                    <center id="loading"><img src="/css/loading.gif"alt=""></center>
                    <div class="table-responsive" id="userList" style="display:none;">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                        <!--<th>#</th>--> @php $i = 1; @endphp
                        <th>Correo electrónico</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Cédula profesional</th>
                        <th>Teléfono móvil</th>
                        <th>Activo</th>
                        <th>Número de cursos terminados</th>
                        <th>Último acceso al sistema</th>
                        <th>Fecha de inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <!--<td>{{$i}}</td>-->@php $i++; @endphp
                            <td><a href="{{ route('show.user.report' , $user->id) }}">{{$user->email}}</a></td>
                            <td>{{ $user->firstname }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->cedula }}</td>
                            <td>{{ $user->mobile_phone }}</td>
                            <td>{{ ($user->enabled == 1) ? 'Sí' : 'No' }}</td>
                            <td>{{ $user->numCompletedCoursesOfAscription($ascription->id) }}</td>
                            <td>{{ $user->last_access }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                {{ $users->links() }}
                </div>
                @else
                    <h3>Sin usuarios</h3>
                @endif

            
            </div>
        </div>
      </div>
	</div>
</div>
@endsection
@section('scripts')
<script>
  $( document ).ready(function() {
    $('#userList').show();
    $('#loading').hide();
  });
</script>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection