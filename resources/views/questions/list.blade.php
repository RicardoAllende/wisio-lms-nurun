@extends('layouts.app')

@section('title','Preguntas')
@section('cta')
  <a href="{{route('questions.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Pregunta</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('modules.index') }}">Módulos</a>
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Listado de preguntas</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Contenido</th>
                            <th>Asignada</th>
                            <th># Opciones</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $i = 1; @endphp
                            @foreach($questions as $question)
                              <tr>
                                <td><a href="{{route('questions.show', $question->id)}}">{{ $i }}</a></td>@php $i++; @endphp
                                <td><a href="{{route('questions.show', $question->id)}}">{{ $question->name }}</a></td>
                                <td>{{ $question->content }}</td>
                                <td>{{ ($question->evaluation_id == null) ? 'No' : 'Asignar'  }}</td>
                                <td>{{ $question->options->count() }}</td>
                                <td>
                                  <a href="{{ route('delete.question', $question->id) }}" class="btn btn-danger" >Eliminar</a>
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
     
