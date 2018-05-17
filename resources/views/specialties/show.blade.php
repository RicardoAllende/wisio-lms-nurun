@extends('layouts.app')

@section('title','Especialidad: '.$specialty->name )
@section('cta')
  <a href="{{ route('specialties.edit', $specialty->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Editar especialidad</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('specialties.index') }}">Especialidades</a>
        </li>
        <li class="active" >
            {{ $specialty->name }}
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="widget lazur-bg p-xl">
                <center>
                    <h2>
                    {{ $specialty->name }}
                    </h2>
                    <h3>
                    {{ $specialty->description }}
                    </h3>
                </center>
            </div>
        </div>
	</div>
</div>
@endsection