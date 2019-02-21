@extends('layouts.app')

@section('title', isset($ascription) ? $ascription->name : 'Página Principal')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center m-t-lg">
                    <h1>
                        Bienvenido a la sección administrativa de WisioLMS
                    </h1>
                    <small>
                        
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection