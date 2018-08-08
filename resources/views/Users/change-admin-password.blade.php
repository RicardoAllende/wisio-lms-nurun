@extends('layouts.app')

@section('title', 'Cambiar contraseña')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="#">Cambiar contraseña</a>
        </li>
    </ol>
@endsection

@section('content')
@if(session()->has('msg'))
    <h5>{{ session('error') }}</h5>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Cambiar contraseña</h5>
        </div>
        <div class="ibox-content">
          <div class="row ">

            {!! Form::open(['route' => 'request.change.admin.password','class'=>'form-horizontal','method' => 'post']) !!}
            
            <div class="form-group">
              {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::password('password',null,['class'=>'form-control','placeholder'=>'Ingrese aquí su nueva contraseña', 'required' => '']) !!}
              </div>
            </div>
            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Guardar',['class'=>'btn btn-primary btn-round', 'value' => 'Actualizar contraseña']) !!}
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