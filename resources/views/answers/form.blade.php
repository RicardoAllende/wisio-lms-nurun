@extends('layouts.app')

@section('title','Categorías')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para crear/editar categoria</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                        @if(!isset($answer))
                          {!! Form::open(['url' => '/answers','class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($answer,['url' => '/answers/'.$answer->id,'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                            <div class="form-group">
                              {!! Form::label('nombre', 'Respuesta:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('answer',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>
                            <!--<div class="form-group">
                              {!! Form::label('nombre', 'Posición:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('position',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>-->

                            <div class="form-group">
                              {!! Form::label('nombre', 'Id_pregunta:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                              <select>
                                @if(isset($answer))
                                  <option id="{{ $answer->question_id }}">Cambiar</option>
                                @endif
                                @foreach ($questions as $question)
                                <option id="{{$question->id}}">{{ $question->content }}</option>
                                @endforeach
                              </select>
                              
                               <!--{!! Form::text('question_id',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}-->
                              </div>
                            </div>

                             <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/categories" class="btn btn-default">Cancelar</a>

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

     