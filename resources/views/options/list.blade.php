@extends('layouts.app')

@section('title','Opciones')
@section('cta')
  <a href="{{ route('options.create') }}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Opción</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('questions.index') }}">Preguntas</a>
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Opciones</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>@php $i=1; @endphp
                            <th>Pregunta</th>
                            <th>Respuesta</th>
                            <th>Valor</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($options as $option)
                          <tr>
                            <td>{{$i}}</td> @php $i++; @endphp
                            <td>@if($option->question != null)<a href="{{ route('questions.show', $option->question->id) }}">{{ $option->question->name }}</a>@endif</td>
                            <td><a href="{{ route('options.show', $option->id) }}">{{ $option->content }}</a></td>
                            <td>{{ ($option->score == 1) ? 'Correcta' : 'Incorrecta' }}</td>
                            <td>
                              <a href="{{ route('delete.option', $option->id) }}" class="btn btn-danger btn_delete">Eliminar</a>
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
    