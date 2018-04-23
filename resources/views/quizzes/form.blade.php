@extends('layouts.app')

@section('title','Quiz')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para crear/editar quiz</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                        @if(!isset($quiz))
                          {!! Form::open(['url' => '/quizzes','class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($quiz,['url' => '/quizzes/'.$quiz->id,'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                            <div class="form-group">
                              {!! Form::label('nombre', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('type_label', 'Tipo:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                              {!! Form::select('type',[''=>'Seleccione una opcion','exam'=>'Examen','evaluation'=>'Evaluación', 'test' => 'Test'],null,['class'=>'form-control', 'required'=>'']) !!}
                              </div>
                            </div>
                             <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/quizzes" class="btn btn-default">Cancelar</a>
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