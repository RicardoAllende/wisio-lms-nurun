@extends('layouts.app')

@section('title','Login Wisio-lms')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Inicio de sesión Wisio LMS</h5>
                </div>
                <div class="ibox-content">
                    <div class="row ">
                        {!! Form::open(['route' => 'request.login','class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']) !!}
                            <div class="form-group">
                                {!! Form::label('email_label', 'Email:',['class'=>'control-label col-sm-2']); !!}
                                <div class="col-sm-10">
                                    {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Correo electrónico', 'required'=>'']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña']) !!}
                              </div>
                            </div>
                            <div class="form-group"> 
                                <div class="col-sm-offset-2 col-sm-10">
                                    {!! Form::submit('Login',['class'=>'btn btn-primary disabled','id'=>'guardar']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection