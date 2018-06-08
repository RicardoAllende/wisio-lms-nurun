@extends('layouts.app')

@section('title','Plantilla: '.$template->name)
@section('cta')
<a href="{{ route('templates.edit', $template->id) }}" class="btn btn-primary"><i class='fa fa-edit'></i>Editar plantilla</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>   <a href="{{ route('templates.index') }}">Plantillas</a> </li>
        <li>{{ $template->name }}</li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Plantilla: {{ $template->name }}</h5>
            </div>
            <div class="ibox-content">
                <div class="contact-box">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <img alt="image" class="m-t-xs img-responsive" src="/{{ $template->url() }}">
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