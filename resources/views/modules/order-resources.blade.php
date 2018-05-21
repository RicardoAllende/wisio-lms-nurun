@extends('layouts.app')

@section('title','Módulos')
@section('cta')
  <a href="{{route('resources.create', $module->id)}}" class="btn btn-primary "><i class='fa fa-plus'></i>Agregar recurso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('courses.show', $module->course->id) }}">Curso: {{ $module->course->name }}</a>
        </li>
        <li>
            <a href="{{ route('modules.show', $module->id) }}">Módulo: {{ $module->name }}</a>
        </li>
        <li>
            Recursos del módulo
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Recursos del módulo {{ $module->name }}</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>Posición</th>
                            <th>Recurso</th>
                            <th>Editar posición</th>
                            <th>Tipo</th>
                            <th>Editar</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($resources as $resource)
                              <tr>
                              <td id="order{{ $resource->id }}">{{ $resource->weight }}</td>
                              <td><a href="{{ route('resources.show' , [$module->id, $resource->id]) }}">{{ $resource->name }}</a></td>
                              <td>
                                <input type="number" value="{{ $resource->weight }}" id="r{{ $resource->id }}">
                                <button class="btnWeight fa fa-edit" data-id="{{$resource->id}}" ></button>
                              </td>
                              <td>{{ $resource->type }}</td>
                              <td>
                                <a href="{{route('resources.edit', [$module->id, $resource->id]) }}" class="btn btn-info btn-round">
                                    <i class='fa fa-edit'></i>Editar
                                </a>
                              </td>
                              <td>
                                  {!! Form::open(['method'=>'delete','route'=>['resources.destroy', $module->id, $resource->id],'style'=>'display:inline;']) !!}
                                    <a href="{{ route('resources.destroy', [$module->id, $resource->id]) }}" class="btn btn-danger btn-round btn_delete">Eliminar</a>
                                  {!! Form::close() !!}
                              </td>
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                      </div>
                    </div>
                    <div class="ibox-footer"></div>
                </div>
              </div>
      </div>
</div>
@endsection

@section('scripts')
<script src="/js/alertify.min.js"></script>
<script src="/js/sweetalert2.min.js"></script>
<script src="/js/method_delete_f.js"></script>
<script>
    var edit;
    $('.btnWeight').click(function(){
        var ruta = "{{ route('change.resource.weight', [$module->id, 'first', 'second']) }}";
        var id = $(this).data('id');
        var route = ruta.replace('first', id);
        var selector = "#r" + id;
        var route = route.replace('second', $(selector).val());
        $.ajax({
            url: route,
            method: 'get',
            success: function(result){
                alertify.success('Cambios guardados');
                $('#order' + id).html(result);
                // alert(result);
            }
        });
        // alert("Clic en el elemento " + route);
    });
</script>
<script>
    //alertify.success("You've clicked OK");
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="/css/alertify.core.css">
<link rel="stylesheet" href="/css/alertify.bootstrap.css">
<link rel="stylesheet" href="/css/alertify.default.css">
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection