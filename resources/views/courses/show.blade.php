@extends('layouts.app')

@section('title','Curso '.$course->name)
@section('cta')
    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Editar curso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('courses.index') }}"> Cursos</a>
        </li>
        <li class="active" >
            {{ $course->name }}
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
                                {{$course->name}}
                            </h2>
                            <small>{{ ($course->category != null) ? "Categoría ".$course->category->name : '' }}</small>
                        </div>
                        <img src="{{$course->getMainImgUrl()}}" width="30%" height="30%" class="m-b-md" alt="Imagen del curso">
                    </div>
                    <div class="col-lg-6"><br><br>
                        <p>Email de resolución de dudas: {{ $course->support_email }}</p>
                        <p>Promedio mínimo del curso: {{ $course->minimum_score }}</p>
                        <p>Promedio mínimo del diplomado: {{ $course->minimum_diploma_score }}</p>
                        <p>Créditos ofrecidos por el curso</p>
                        <p>Estudiantes inscritos: {{ $course->users()->count() }}</p>
                        <p>{{ $course->modules()->count() }} módulos</p>
                        <p>Slug: {{ $course->slug }}</p>
                        <p>Evaluaciones finales: {{ $course->finalEvaluations()->count() }}</p>
                        <h4 class="media-heading">Descripción del curso</h4>
                        <p>{!! $course->description !!}</p>
                        <p>Fecha de inicio: {{ $course->start_date }}</p>
                        <p> Fecha de término: {{ $course->end_date }}</p>
                    </div>
                </div>
                        
            </div>

            <div class="ibox float-e-margins">
                <div class="row">
                    <div class="col-lg-9">
                        <h3>Información de los módulos</h3>
                        @if ($course->hasModules())
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
                                    @foreach($course->modules as $module) 
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
                            <a href="{{ route('modules.create').'?course_id='.$course->id }}" class="btn btn-primary btn-round">Crear módulo</a>
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
                                        @if(count($course->tags) > 0)
                                        <ul class="tag-list" style="padding: 0;">
                                            @foreach($course->tags as $tag)
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
<div class="modal inmodal" id="modal-tags" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tag modal-icon"></i>
                <h4 class="modal-title">Asingación de Etiquetas</h4>
                <small class="font-bold">Selecciona las etiquetas que quieras asignar al curso o crea una nueva etiqueta en la parte inferior.</small>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="tag-list" style="padding: 0;">
                            @foreach(\App\Tag::all() as $tag)
                            <li>
                                <a href class="tag-item-attach" data-tag="{{ $tag->id }}"><i class="fa fa-tag"></i> {{ $tag->tag }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-8 text-left">
                        <form action="" class="form-inline" id="form-tag">
                            {{ csrf_field() }}
                            <input type="text" class="form-control" name="tag" id="tag" placeholder="Escribe nueva etiqueta">
                            <button type="submit" class="btn btn-primary" id="create-tag">Crear y Asignar</button>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
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
    <script>
        $(document).ready(function() {
            $('#form-tag').on('submit', function(e) {
                e.preventDefault();
                if($('#tag').val() != '') {
                    $.post('/admin/api/tags/create', {
                        '_token': '{!! csrf_token() !!}',
                        tag: $('#tag').val(),
                        course: {{ $course->id }}
                    }).done(function(response) {
                        if(response == 'ok') {
                            swal("¡Listo!", "Se guardó y asignó correctamente la etiqueta al curso.", "success").then((value) => {
                                window.location.reload();
                            });
                        } else {
                            swal("¡Ups!", "No pudimos guardar la etiqueta. Intenta nuevamente.", "error");
                        }
                    });
                }
            });
    
            $('.tag-item-attach').on('click', function(e) {
                e.preventDefault();
                var tagElement = $(this);
    
                console.log($(this).data('tag'));
                $.post('/admin/api/tags/attach', {
                    '_token': '{!! csrf_token() !!}',
                    tag: $(this).data('tag'),
                    course: {{ $course->id }}
                }).done(function(response) {
                    if(response == 'ok') {
                        swal("¡Listo!", "Se guardó y asignó correctamente la etiqueta al curso.", "success").then((value) => {
                            window.location.reload();
                        });
                    } else {
                        swal("¡Ups!", "No pudimos asignar la etiqueta. Intenta nuevamente.", "error");
                    }
                }).fail(function() {
                    swal("¡Ups!", "No pudimos asignar la etiqueta. Intenta nuevamente.", "error");
                });
            });
    
    
            $('.tag-item').on('click', function(e) {
                e.preventDefault();
                var tagElement = $(this);
    
                console.log($(this).data('tag'));
                $.post('/admin/api/tags/detach', {
                    '_token': '{!! csrf_token() !!}',
                    tag: $(this).data('tag'),
                    course: {{ $course->id }}
                }).done(function(response) {
                    if(response == 'ok') {
                        tagElement.parent().hide();
                    } else {
                        swal("¡Ups!", "No pudimos quitar la etiqueta. Intenta nuevamente.", "error");
                    }
                }).fail(function() {
                    swal("¡Ups!", "No pudimos quitar la etiqueta. Intenta nuevamente.", "error");
                });
            });
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection