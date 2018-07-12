@extends('layouts.app')

@section('title', (isset($user)) ? 'Editar usuario' : 'Crear usuario')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('users.index') }}">Usuarios</a>
        </li>
        <li class="active" >
            {{ (isset($user)) ? 'Editar usuario' : 'Crear usuario' }}
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Formulario para {{(isset($user)) ? 'editar usuario' : 'crear usuario'}}</h5>
        </div>
        <div class="ibox-content">
          <div class="row ">
            @if(!isset($user))
              {!! Form::open(['route' => 'users.store','class'=>'form-horizontal','method' => 'post']) !!}
            @else
              {!! Form::model($user,['route' => ['users.update', $user->id],'class'=>'form-horizontal','method' => 'put']) !!}
            @endif
            <div class="form-group">
              {!! Form::label('email', 'Email:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Email', 'required' => '']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('firstname', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::text('firstname',null,['class'=>'form-control','placeholder'=>'Nombre']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('lastname', 'Apellidos:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10"> 
                {!! Form::text('lastname',null,['class'=>'form-control','placeholder'=>'Apellidos']) !!}
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('professional_license', 'Cédula profesional:',['class'=>'control-label col-sm-2']); !!}
                <div class="col-sm-10"> 
                  {!! Form::text('professional_license',null,['class'=>'form-control','placeholder'=>'Cédula profesional']) !!}
                </div>
            </div>

            <div class="form-group">
              {!! Form::label('ascription_id', 'Adscripción o farmacia a la que pertenece:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
              <select name="ascription_id" id="ascription_id" class="form-control" required>
                @if(isset($user))
                  @if($user->ascription != null)
                    <option value="{{$user->ascription->id}}">{{ $user->ascription->name }} (actual)</option>
                  @else
                    <option value="">Seleccionar</option>
                  @endif
                @else
                  <option value="">Seleccionar</option>
                @endif

                @foreach($ascriptions as $ascription)
                  <option value="{{$ascription->id}}">{{ $ascription->name }}</option>
                @endforeach
              </select>
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('role_id', 'Tipo de usuario:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
              <select name="role_id" id="role_id" class="form-control" required>
                @if(isset($user))
                  <option value="{{$user->role->id}}">{{ $user->role->description }} (actual)</option>
                @else
                  <option value="">Seleccionar</option>
                @endif
                @foreach($roles as $role)
                  <option value="{{$role->id}}">{{ $role->description }}</option>
                @endforeach
              </select>
              </div>
            </div>

            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <a href="{{route('users.index')}}" class="btn btn-default">Cancelar</a>
                {!! Form::submit('Guardar',['class'=>'btn btn-primary btn-round']) !!}
                @if(isset($user))
                  &nbsp;&nbsp;<a href="{{ route('reset.default.password', $user->id) }}" class="btn btn-default btn-round" >Resetear contraseña por defecto</a>
                @endif
              </div>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
        <div class="ibox-footer">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection