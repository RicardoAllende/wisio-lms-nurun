@extends('layouts.app')

@section('title','Recurso')
@section('cta')
<a href="{{ route('resources.destroy', $resource->id) }}" class="btn btn-primary"><i class='fa fa-edit'></i>Eliminar recurso</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de la adscripción</h5>
            </div>
            <div class="ibox-content">
                <div class="contact-box">
                    <div class="col-sm-4">
                        <div class="text-center">
                        @switch($mimetype)
                            @case('image')
                                <img alt="image" class="m-t-xs img-responsive" src="/{{ $attachment->url }}">
                                @break

                            @case('video')
                                <video width="320" height="240" controls>
                                    <source src="/{{ $attachment->url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                @break

                            @case('document')
                                <a href="/{{ $attachment->url }}">Documento</a>
                                @break
                            @default
                                <h1>Default clause</h1>
                        @endswitch
                        
                            
                            <!--<div class="m-t-xs font-bold">Usuario</div>-->
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