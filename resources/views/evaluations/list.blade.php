@extends('layouts.app')

@section('title','Evaluaciones')
@section('cta')
  <a href="{{route('evaluations.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Evaluación</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          Evaluaciones
        </li>
    </ol>
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
                            <th>#</th>@php $i=1; @endphp
                            <th>Evaluación</th>
                            <th>Módulo</th>
                            <th>Tipo</th>
                            <th>Fecha de creación</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluations as $evaluation)
                              <tr>
                              <td><a href="{{ route('evaluations.show', $evaluation->id) }}">{{ $i }}</a></td> @php $i++; @endphp
                              <td><a href="{{ route('evaluations.show', $evaluation->id) }}">{{ $evaluation->name }}</a></td>
                              <td><a href="{{ route('modules.show', $evaluation->module->id) }}">{{ $evaluation->module->name }}</a></td>
                              <td>{{ ($evaluation->type == 'd')? 'Diagnóstica' : 'Final' }}</td>
                              <td>{{ $evaluation->created_at }}</td>
                              <td>
                                  {!! Form::open(['method'=>'delete','route'=>['evaluations.destroy',$evaluation->id],'style'=>'display:inline;']) !!}
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']); !!}
                                    <!--<a href="{{route('evaluations.destroy',$evaluation->id)}}" class="btn btn-danger btn_delete" >Eliminar</a>-->
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
     
