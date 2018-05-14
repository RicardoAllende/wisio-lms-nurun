@extends('layouts.app')

@section('title','Módulos')
@section('cta')
  <a href="{{route('modules.create')}}?expert_id={{$expert->id}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Módulo</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                  

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Expertos</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Módulo</th>
                            <th>Recursos</th>
                            <th>Resumen</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>@php $i = 1;  @endphp
                            @foreach($modules as $module)
                              <tr>
                              <td>{{$i}}</td>@php $i++;  @endphp
                              <td><a href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</a></td>
                              <td>{{ $module->resources->count() }}</td>
                              <td>{{ $module->summary }}</td>
                              <td>
                              @if($expert->belongsToModule($module->id))
                                <a href="{{ route('detach.module.to.expert', [$expert->id, $module->id]) }}" class="btn btn-danger">Quitar</a>
                              @else
                                <a href="{{ route('attach.module.to.expert', [$expert->id, $module->id]) }}" class="btn btn-info">Agregar</a>
                              @endif
                              </td>
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