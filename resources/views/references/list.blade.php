@extends('layouts.app')

@section('title','Referencias')
@section('cta')
  <a href="{{route('references.create', $module->id)}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear referencia</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          <a href="{{ route('modules.show', $module->id) }}">Módulo: <strong>{{ $module->name }}</strong></a>
        </li>
        <li>
          Administrar referencias
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      <h5>Referencias</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Referencia</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($references as $reference)
                              <tr>
                                <td><a href="{{ route('references.show', [$module->id, $reference->id]) }}">{{ $i }}</a></td> @php $i++; @endphp
                                <td><a href="{{ route('references.show', [$module->id, $reference->id]) }}">{!! $reference->content !!}</a></td>
                                <td>
                                  {!! Form::open(['method'=>'delete','route'=>['references.destroy', $module->id,  $reference->id],'style'=>'display:inline;']) !!}
                                    <a class='btn btn-danger btn_delete'>Eliminar</a>
                                  {!! Form::close() !!}
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