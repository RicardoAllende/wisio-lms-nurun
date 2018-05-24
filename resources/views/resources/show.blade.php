@extends('layouts.app')

@section('title','Recurso: '.$resource->name)
@section('cta')
<a href="{{ route('resources.edit', [$module->id, $resource->id]) }}" class="btn btn-primary"><i class='fa fa-edit'></i>Editar recurso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('courses.show', $module->course->id) }}">Curso: <strong>{{ $module->course->name }}</strong></a>
        </li>
        <li class="active">
            <a href="{{ route('modules.show', $module->id) }}">Módulo: <strong>{{ $module->name }}<strong></a>
        </li>
        <li>{{ $resource->name }}</li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Recurso: {{ $resource->name }}</h5>
            </div>
            <div class="ibox-content">
                <div class="contact-box">
                    <div class="col-sm-12">
                        <div class="text-center">
                        @switch($type)
                            @case('image')
                                <img alt="image" class="m-t-xs img-responsive" src="/{{ $attachment->url }}">
                                @break
                            @case('video')
                                <video width="320" height="240" controls>
                                    <source src="/{{ $attachment->url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                @break

                            @case('pdf')
                            <embed src="/{{ $attachment->url }}" height="600px" width="100%" type="application/pdf">
                                <a href="/{{ $attachment->url }}">Documento</a>
                                @break
                        @endswitch
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
@section('scripts')
<script src="/js/sweetalert2.min.js"></script>
<script src="/js/method_delete_f.js"></script>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection