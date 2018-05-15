@extends('layouts.app')

@section('title','Módulos')
@section('cta')
  <a href="{{route('module.form.for.course', $course_id)}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Nuevo Módulo</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Evaluaciones</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Módulo</th>
                            <th>Descripción</th>
                            <th>Evaluaciones</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                            @foreach($modules as $module)
                              <tr>
                              <td>{{$i}}</td>
                              <td><a href="{{ action('ModulesController@show' , $module->id) }}">{{ $module->name }}</a></td>
                              <td>{{ $module->description }}</td>
                              <td>{{ $module->evaluations->count() }}</td>
                              <td>{{ $module->start_date }}</td>
                              <td>{{ $module->end_date }}</td>
                              <td>
                                @if($module->belongsToExpert($expert->id))
                                      <a href="{{ route('detach.module.to.expert', [$expert->id, $module->id]) }}" class="btn btn-danger btn-rounded">Quitar</a>
                                    @else
                                      <a href="{{ route('attach.module.to.course', [$expert->id, $module->id]) }}" class="btn btn-success btn-rounded">Agregar</a>
                                @endif
                              </td>
                              </tr>
                              @php $i++; @endphp
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