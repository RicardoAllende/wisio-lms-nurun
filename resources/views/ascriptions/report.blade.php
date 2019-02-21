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

                   
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="users-table">
                        <thead>
                            <tr>
                                <th>Correo electrónico</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Cédula profesional</th>
                                <th>Teléfono móvil</th>
                                <th>Activo</th>
                                <th>Número de cursos terminados</th>
                                <th>Inscripción</th>
                                <th>Último acceso al sistema</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            
            </div>
        </div>
      </div>
	</div>
</div>
@endsection
@section('scripts')
<script>
  $( document ).ready(function() {
    // $('#userList').show();
    // $('#loading').hide();
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'Bfrtip',
        ajax: "{{ route('get.users.data.admin.ascription', $ascription->id) }}",
        columns: [
            {data: 'email'},
            {data: 'firstname'},
            {data: 'lastname'},
            {data: 'professional_license'},
            {data: 'mobile_phone'},
            {data: 'status'},
            {data: 'numCompletedCoursesOfAscription'},
            {data: 'created_at'},
            {data: 'last_access'},
        ]
    });
  });
</script>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection