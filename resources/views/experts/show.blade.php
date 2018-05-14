@extends('layouts.app')

@section('title', $expert->name)
@section('cta')
    <a href="{{ route('experts.edit', $expert->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Experto</a>
    <a href="{{route('list.specialties.for.expert', $expert->id)}}" class="btn btn-primary "><i class='fa fa-edit'></i>Administrar especialidades</a>
    <a href="{{route('list.modules.for.expert', $expert->id)}}" class="btn btn-primary "><i class='fa fa-edit'></i>Administrar módulos</a>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="widget-head-color-box navy-bg p-lg text-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="m-b-md">
                            <h2 class="font-bold no-margins">
                                {{ $expert->name }}
                            </h2>
                                <small>Experto</small>
                            </div>
                            <img src="{{ $expert->getMainImgUrl() }}" style="width:20%; height:20%;" class="img-circle circle-border m-b-md" alt="profile">
                            <div>
                                <span>Ha participado en {{ $expert->modules->count() }} módulos</span>
                                @if($expert->hasSpecialties())
                                    <ul class="list-unstyled m-t-md">
                                        @foreach($expert->specialties as $specialty)
                                            <li>
                                                <span class="fa fa-user-md"></span>
                                                {{ $specialty->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    Sin especialidades
                                @endif
                                <p>Resumen: {{ $expert->summary }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            @if($expert->hasModules())
                                <h3>Módulos en los que ha participado</h3>
                                @foreach($expert->modules as $module)
                                    <a class="btn btn-success" href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</a><br><br>
                                @endforeach
                            @else
                                <p>Este experto no está relacionado con ningún módulo</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection