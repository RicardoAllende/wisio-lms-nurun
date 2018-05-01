@extends('layouts.app')

@section('title','Adscripciones')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      @if(isset($evaluation))
                        <h5>Editar adscripción</h5>
                      @else
                        <h5>Crear adscripción</h5>
                      @endif
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                        @if(!isset($evaluation))
                          {!! Form::open(['route' => 'ascriptions.store','class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($ascription,['route' => ['ascriptions.update'],'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                            <div class="form-group">
                                {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre de la ascripción o farmacia', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('description', 'Descripción:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción', 'required' => '']) !!}
                              </div>
                            </div>

                            <div class="form-group"> 
                              <div class="col-sm-offset-2 col-sm-10">
                              <a href="{{route('ascriptions.index')}}" class="btn btn-default">Cancelar</a>
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