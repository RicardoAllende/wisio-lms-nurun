@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center m-t-lg">
                    <h1>
                        Bienvenido a Academia sanofi
                    </h1><br><br>
                    <button type="button" class="btn btn-success btn-lg btn-round" data-toggle="modal" data-target="#myModal" style="bottom: 50%;">Iniciar sesión</button>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Inicio de sesión</h4>
                            </div>
                            <div class="modal-body">
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
                                                {!! Form::submit('Login',['class'=>'btn btn-primary','id'=>'guardar']) !!}
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection