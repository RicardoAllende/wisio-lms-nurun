@extends('layouts.app')

@section('title', (isset($question)) ? 'Editar pregunta' : 'Crear pregunta' )

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('modules.index') }}">Módulos</a>
        </li>
        <li>
            <a href="{{ route('questions.index') }}">Preguntas</a>
        </li>
        <li>
            {{ (isset($question)) ? 'Editar pregunta' : 'Crear pregunta' }}
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ (isset($question)) ? 'Editar pregunta' : 'Crear pregunta' }}</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                        @if(!isset($question))
                          {!! Form::open(['route' => 'questions.store','class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($question,['route' => ['questions.update', $question->id],'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                          @if(isset($evaluation))
                            <div class="form-group">
                              {!! Form::label('evaluation', 'Evaluación:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('evaluation',$evaluation->name,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '', 'disabled'=>'']) !!}
                               <input type="hidden" name="evaluation_id" value="{{$evaluation->id}}">
                              </div>
                            </div>
                          @else
                            <div class="form-group">
                              {!! Form::label('evaluation_id', 'Evaluación a la que pertenece la pregunta:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                <select name="evaluation_id" id="evaluation_id" required class="form-control">
                                <option value="">Selecciona una evaluación</option>
                                  @foreach($evaluations as $evaluation)
                                    <option value="{{$evaluation->id}}">{{$evaluation->name}}</option>
                                  @endforeach
                               </select>
                               <input type="hidden" name="evaluation_id" value="{{$evaluation->id}}">
                              </div>
                            </div>
                          @endif
                            <div class="form-group">
                              {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('content', 'Contenido de la pregunta:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('content',null,['class'=>'form-control','placeholder'=>'Contenido de la pregunta', 'required' => '']) !!}
                              </div>
                            </div>

                            <div class="form-group"> 
                              <div class="col-sm-offset-2 col-sm-10">
                              <a href="{{ URL::previous() }}" class="btn btn-default">Cancelar</a>
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