@extends('layouts.app')

@section('title','Curso '.$course->name)
@section('cta')
  <a href="{{ route('modules.create', 'forDiplomat='.$course->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Crear módulo</a>
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
            <div class="ibox float-e-margins">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Módulos pertenecientes al diplomado</h3>
                        @if ($course->hasDiplomaModules())
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
                                    @foreach($course->modulesForDiplomat as $module) 
                                        <tr>
                                        <td><a href="{{ route('modules.show', $module->id) }}">{{ $i }}</a></td>
                                        <td><a href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</a></td>
                                        <td><a href="{{ route('modules.edit', $module->id) }}" class="btn btn-primary" >Editar</a></td>
                                        <td>
                                            {!! Form::open(['method'=>'DELETE','route'=>['ascriptions.destroy',$module->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
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
                        <h3><strong>Este diplomado aún no tiene módulos asignados, ¿desea agregar alguno?</strong></h3><br>
                        @endif
                        <a href="{{ route('modules.create', 'forDiplomat='.$course->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Crear módulo</a>
                    </div>
                    <div class="col-lg-3">
                        
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