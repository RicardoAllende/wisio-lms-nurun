@extends('layouts.app')

@section('title',(isset($option)) ? 'Editar opción' : 'Crear opción'))

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('questions.index') }}">Preguntas</a>
        </li>
        <li>
            <a href="{{ route('options.show') }}">Opciones</a>
        </li>
        <li>
            {{ (isset($option)) ? 'Editar opción' : 'Crear opción') }}
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>(isset($option)) ? 'Editar opción' : 'Crear opción')</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row">
                        @php $isCorrect = false; @endphp
                        @if(!isset($option))
                          {!! Form::open(['route' => 'options.store','class'=>'form-horizontal','method' => 'post']) !!}
                          @if(isset($question))
                            @php $questionsExists = true;  @endphp
                            <h4>Nombre de la pregunta: {{ $question->name }} </h4>
                            <h4>Pregunta: {{ $question->content }} </h4>
                            {!! Form::hidden('question_id', $question->id,['class'=>'form-control']) !!}
                          @else
                            @php $questionsExists = false;  @endphp
                            <div class="form-group">
                              {!! Form::label('nombre', 'Pregunta:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                <select name='question_id' required>
                                  @foreach ($questions as $question)
                                    <option value="{{$question->id}}">{{ $question->content }}</option>
                                  @endforeach
                                </select>
                              
                              <!--{!! Form::text('question_id',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}-->
                              </div>
                            </div>
                          @endif
                        @else
                          @php $isCorrect = ($option->score == 1) ? true : false @endphp
                          {!! Form::model($option,['route' => array('options.update', $option->id),'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                            <div class="form-group">
                              {!! Form::label('content', 'Opción:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('content',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              {!! Form::label('feedback', 'Feedbak:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                {!! Form::text('feedback',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              {!! Form::label('score', '¿Es correcta?:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                <label>{!! Form::checkbox('score', 1, $isCorrect, ['class' => '']) !!}  Opción correcta</label>
                              </div>
                            </div>
                             <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/questions" class="btn btn-default">Cancelar</a>

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

     