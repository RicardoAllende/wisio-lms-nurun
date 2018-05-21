@extends('layouts.app')

@section('title','Ver referencia ')
@section('cta')
    <a href="{{ route('references.edit', [$module->id, $reference->id]) }}" class="btn btn-primary"><i class='fa fa-edit'></i>Editar referencia</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('modules.show', $module->id) }}">Módulo: {{ $module->name }}</a>
        </li>
        <li class="active" >
            <a href="{{ route('references.index', $module->id) }}">Referencias</a>
        </li>
        <li>Ver referencia</li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Referencia</h5>
            </div>
            <div class="ibox-content">
                <div class="contact-box">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-9">
                        <h3><strong>Referencia para el módulo: {{ $module->name }} </strong></h3>
                        <div>
                            {!! $reference->content !!}
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                </div>

            </div>
        </div>
      </div>
	</div>
</div>
@endsection