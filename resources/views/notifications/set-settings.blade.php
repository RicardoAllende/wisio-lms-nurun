@extends('layouts.app')

@section('title', (isset($course)) ? 'Editar curso' : 'Crear curso')

@section('subtitle')
    <ol class="breadcrumb">
      @if(isset($ascription))
        <li><a href="{{route('ascriptions.show', $ascription->id)}}">Adscripción: {{ $ascription->name }}</a></li>
        <li>Crear curso</li>
      @else
        <li>
            <a href="{{ route('courses.index') }}"> Cursos</a>
        </li>
        <li class="active" >
            {{ (isset($course)) ? 'Editar curso' : 'Crear curso' }}
        </li>
      @endif
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{(isset($course)) ? 'Editar curso' : 'Crear curso'}}</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                        {!! Form::model($settings, ['route' => 'update.settings','class'=>'form-horizontal','method' => 'post']) !!}
                        <div class="form-group">
                          {!! Form::label('mailing', '¿Activar envío de notificaciones?',['class'=>'control-label col-sm-2']); !!}
                          <div class="col-sm-10">
                            {!! Form::select('mailing', ['1' => 'Sí', '0' => 'No'], null, ['class' => 'form-control', 'required'=>'']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('max_month_reminders', 'Número de notificaciones mensuales:',['class'=>'control-label col-sm-2']); !!}
                          <div class="col-sm-10"> 
                            {!! Form::number('max_month_reminders',null,['class'=>'form-control', 'required'=>'']) !!}
                          </div>
                        </div>


                        <div class="form-group">
                          {!! Form::label('max_week_reminders', 'Número de notificaciones semanales:',['class'=>'control-label col-sm-2']); !!}
                          <div class="col-sm-10"> 
                            {!! Form::number('max_week_reminders',null,['class'=>'form-control', 'required'=>'']) !!}
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('max_sms_reminders', 'Número de mensajes de texto:',['class'=>'control-label col-sm-2']); !!}
                          <div class="col-sm-10"> 
                            {!! Form::number('max_sms_reminders',null,['class'=>'form-control', 'required'=>'']) !!}
                          </div>
                        </div>
                          
                          <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                              {!! Form::submit('Guardar',['class'=>'btn btn-primary', 'id' => 'btnSave']) !!}
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
