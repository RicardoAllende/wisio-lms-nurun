@extends('layouts.app')

@section('title','Usuarios')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Formulario para crear/editar usuario</h5>
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
                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
                ¿Enviar notificación a correo electrónico? {!! Form::checkbox('send', '1', true)  !!}
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
              {!! Form::label('birthday', 'Fecha de nacimiento:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10"> 
                {!! Form::date('birthday',null,['class'=>'form-control','placeholder'=>'']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('mobile_phone', 'Teléfono celular:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10"> 
                {!! Form::number('mobile_phone',null,['class'=>'form-control','placeholder'=>'']) !!}
              </div>
            </div>

            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <a href="{{route('users.index')}}" class="btn btn-default">Cancelar</a>
                {!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
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