@extends('layouts.app')

@section('title','Expertos')
@section('cta')
  <a href="{{route('experts.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i>Crear experto</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          <a href="{{ route('modules.index') }}"> Módulos</a>
        </li>
        <li class="active" >
            <a href="{{ route('modules.show', $module->id) }}">Módulo: {{ $module->name }}</a>
        </li>
        <li>Administrar expertos</li>
    </ol>
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
                                    <th>Experto</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($experts as $expert)
                                    <tr>
                                        <td>{{$i}}</td>@php $i++; @endphp
                                        <td><a href="{{ route('experts.show', $expert->id) }}">{{ $expert->name }}</a></td>
                                        <td>
                                        @if($expert->belongsToModule($module->id))
                                            <a href="{{ route('detach.module.to.expert', [$expert->id, $module->id]) }}" class="btn btn-danger btn-round">Desasociar del módulo</a>
                                        @else
                                            <a href="{{ route('attach.module.to.expert', [$expert->id, $module->id]) }}" class="btn btn-success btn-round">Asociar al módulo</a>
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
     