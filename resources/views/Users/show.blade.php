@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Usuario</a>
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
            <!--<div class="col-sm-4">
                <div class="text-center">
                    <img alt="image" class="img-circle m-t-xs img-responsive" src="/{{ $user->photo }}">
                    <div class="m-t-xs font-bold">Usuario</div>
                </div>
            </div>-->
            <div class="col-sm-12">
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
            <div class="clearfix"></div>
                
        </div>

        </div>
      </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection