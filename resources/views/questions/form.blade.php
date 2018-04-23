@extends('layouts.app')

@section('title','Preguntas')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Agregar pregunta</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                          {!! Form::open(['url' => '/questions','class'=>'form-horizontal','method' => 'post']) !!}
                        @if(isset($quiz))
                            <div class="form-group">
                              {!! Form::label('quiz', 'Quiz:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                              {!! Form::text('quiz_name',$quiz->name,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '', 'disabled' => 'disabled']) !!}
                              {!! Form::hidden('quiz_id', $quiz->id,['class'=>'form-control','placeholder'=>'','id'=>'featured_image']) !!}
                              </div>
                            </div>
                        @endif
                            <div class="form-group">
                              {!! Form::label('nombre_', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('content', 'Contenido de la pregunta:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('content',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('type_label', 'Tipo de pregunta:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                              {!! Form::select('type',[''=>'Seleccione una opcion','1'=>'Verdadero/falso','2'=>'Opción múltiple'],null,['id'=>'type', 'class'=>'form-control', 'required'=>'']) !!}
                              </div>
                            </div>
                            <div class="form-group" id="typeTF">
                              {!! Form::label('type_label', 'Correcta:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                <select name="correct" id="correct">
                                  <option value="">Seleccionar opción</option>
                                  <option value="1">Verdadero</option>
                                  <option value="0">Falso</option>
                                </select>
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

@section('scripts')

<script type="text/javascript">
  $('#typeTF').hide();
  $('#type').on("change", function(){
    if($('#type').val() == 1 ){
      $('#typeTF').show();
    }else{
      $('#typeTF').hide();
      $('#correct').val('');
    }
  });
</script>
@endsection