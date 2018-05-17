@extends('layouts.app')

@section('title', (isset($specialty)) ? 'Editar especialidad' : 'Crear especialidad')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('specialties.index') }}">Especialidades</a>
        </li>
        <li class="active">
          {{(isset($specialty)) ? 'Editar especialidad' : 'Crear especialidad'}}
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ (isset($specialty)) ? 'Editar especialidad' : 'Crear especialidad' }}</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                        @if(!isset($specialty))
                          {!! Form::open(['route' => 'specialties.store','class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($specialty,['route' => ['specialties.update', $specialty->id],'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                            <div class="form-group">
                              {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>
                             <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="{{route('specialties.index')}}" class="btn btn-default">Cancelar</a>

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