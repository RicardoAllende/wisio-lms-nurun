@extends('layouts.app')

@section('title','Curso '.$diploma->name)
@section('cta')
    <a href="{{ route('courses.edit', $diploma->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Editar curso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('courses.index') }}"> Cursos</a>
        </li>
        <li class="active" >
            {{ $diploma->name }}
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="widget-head-color-box navy-bg p-lg text-center">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="m-b-md">
                            <h2 class="font-bold no-margins">
                                {{$diploma->name}}
                            </h2>
                            <small>{{ ($diploma->category != null) ? "Categoría ".$diploma->category->name : '' }}</small>
                        </div>
                        <img src="{{$diploma->getMainImgUrl()}}" width="30%" height="30%" class="m-b-md" alt="Imagen del curso">
                    </div>
                    <div class="col-lg-6"><br><br>
                        <p>Email de resolución de dudas: {{ $diploma->support_email }}</p>
                        <p>Promedio mínimo del curso: {{ $diploma->minimum_score }}</p>
                        <p>Promedio mínimo del diplomado: {{ $diploma->minimum_diploma_score }}</p>
                        <p>Créditos ofrecidos por el curso</p>
                        <p>Estudiantes inscritos: {{ $diploma->users()->count() }}</p>
                        <p>{{ $diploma->modules()->count() }} módulos</p>
                        <p>Slug: {{ $diploma->slug }}</p>
                        <p>Evaluaciones finales: {{ $diploma->finalEvaluations()->count() }}</p>
                        <h4 class="media-heading">Descripción del curso</h4>
                        <p>{!! $diploma->description !!}</p>
                        <p>Fecha de inicio: {{ $diploma->start_date }}</p>
                        <p> Fecha de término: {{ $diploma->end_date }}</p>
                    </div>
                </div>
                        
            </div>

            <div class="ibox float-e-margins">
                <div class="row">
                    <div class="col-lg-9">
                        <h3>Información de los módulos</h3>
                        @if ($diploma->hasModules())
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Módulo</th>
                                        <th>Editar módulo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach($diploma->modules as $module) 
                                        <tr>
                                        <td><a href="{{ route('modules.show', $module->id) }}">{{ $i }}</a></td>
                                        <td><a href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</a></td>
                                        <td><a href="{{ route('modules.edit', $module->id) }}" class="btn btn-primary" >Editar</a></td>
                                        <td>
                                            {!! Form::open(['method'=>'DELETE','route'=>['modules.destroy',$module->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                                <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
                                            {!! Form::close() !!}
                                        </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <h3><strong>Este curso aún no tiene módulos asignados, ¿desea agregar alguno?</strong></h3><br>
                        @endif
                            <a href="{{ route('modules.create').'?course_id='.$diploma->id }}" class="btn btn-primary btn-round">Crear módulo</a>
                    </div>
                    <div class="col-lg-3">
                        {{-- Inicia Tag Cloud --}}
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Tag Cloud</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if(count($diploma->tags) > 0)
                                        <ul class="tag-list" style="padding: 0;">
                                            @foreach($diploma->tags as $tag)
                                            <li>
                                                <a href class="tag-item" data-tag="{{ $tag->id }}"><i class="fa fa-times"></i> {{ $tag->tag }}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @else
                                        El curso no tiene etiquetas
                                        @endif
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary btn-block btn-sm m-t-sm" data-toggle="modal" data-target="#modal-tags">
                                    Asigna una etiqueta
                                </button>
        
                            </div>
                        </div>
                        {{-- Termina Tag Cloud --}}
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