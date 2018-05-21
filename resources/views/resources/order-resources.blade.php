@extends('layouts.app')

@section('title','resourceos')
@section('cta')
  <a href="{{route('resources.create', $module->id)}}" class="btn btn-primary "><i class='fa fa-plus'></i>Crear recurso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('courses.show', $module->course->id) }}">Curso: <strong>{{ $module->course->name }}</strong></a>
        </li>
        <li class="active">
            <a href="{{ route('modules.show', $module->id) }}">Módulo: <strong>{{ $module->name }}<strong></a>
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                  

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>resourceos</h5>
                        
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Recursos</th>
                                    <th>Orden</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($resources as $resource)
                                    <tr>
                                        <td>{{$i}}</td>@php $i++; @endphp
                                        <td><a href="{{ route('resources.show', [$module->id, $resource->id]) }}">{{ $resource->name }}</a></td>
                                        <td><input type="number" placeholder="Orden" ></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ibox-footer">
                      
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