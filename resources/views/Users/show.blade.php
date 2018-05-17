@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Usuario</a>
@endsection

@if($user->hasAscriptions())
    @section('subtitle')
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ route('ascriptions.show', $user->ascriptions->first()->id) }}">
                Adscripción: <strong>{{ $user->ascriptions->first()->name }}<strong></a>
            </li>
        </ol>
    @endsection
@endif

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
                            @if($user->gender != null)<span class="{{ ($user->gender == 'M') ? 'fa fa-male' : 'fa fa-female' }}"></span>@endif
                            {{ $user->firstname }} {{ $user->lastname }}
                        </h2>
                        <ul class="list-unstyled m-t-md">
                            @if($user->hasAscriptions())
                            <li>
                                <span class="fa fa-th-large m-r-xs"></span>
                                <label>Adscripción:</label>
                                {{ $user->ascriptions->first()->name }}
                            </li>
                            @endif
                            <li>
                                <span class="fa fa-envelope m-r-xs"></span>
                                <label>Email:</label>
                                {{ $user->email }}
                            </li>
                            <li>
                                <span class="fa fa-home m-r-xs"></span>
                                <label>Dirección:</label>
                                {{ $user->city }}, {{ $user->state }}, {{ $user->postal_code }}, {{ $user->address }}
                            </li>
                            <li>
                                <span class="fa fa-mobile-phone m-r-xs"></span>
                                <label>Teléfono móvil:</label>
                                {{ $user->mobile_phone }}
                            </li>
                            <li>
                                <span class="fa fa-address-card-o m-r-xs"></span>
                                <label>Cédula profesional:</label>
                                {{ $user->cedula }}
                            </li>
                            <li>
                                <span class="fa fa-plus-circle m-r-xs"></span>
                                <label>Tipo de consulta</label>
                                {{ $user->consultation_type }}
                            </li>
                            <li>
                                <span class="fa fa-book m-r-xs"></span>
                                <label>Especialidad</label>
                                {{ $user->specialty }}
                            </li>
                        </ul>
                    </div> 
                </div>
            </div>
            <div class="clearfix"></div>
                
        </div>

        </div>
      </div>
	</div>
</div>
@endsection