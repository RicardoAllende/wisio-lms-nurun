@extends('layouts.app')

@section('title','Nuevo recurso')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('courses.show', $module->course->id) }}">Curso: <strong>{{ $module->course->name }}</strong></a>
        </li>
        <li class="active">
            <a href="{{ route('courses.show', $module->id) }}">Módulo: <strong>{{ $module->name }}<strong></a>
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Editar recurso de <a href="{{ route('modules.show', $module->id) }}" >{{ $module->name }}</a></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        {!! Form::model($resource, ['route' => ['resources.update', $module->id, $resource->id],'class'=>'form-horizontal','method' => 'put']) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre del recurso', 'required'=>'']) !!}
                            </div>
                        </div>
                        <input type="hidden" id="attachment_id" value="" name="attachment_id">
                        <input type="hidden" id="module_id" value="{{ $module->id }}" name="module_id">
                        <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="{{route('modules.show', $module->id )}}" class="btn btn-default">Cancelar</a>
                            {!! Form::submit('Guardar',['class'=>'btn btn-primary', 'id' => 'btnSave']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    </div>
                    <div class="ibox-footer" id='result'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection