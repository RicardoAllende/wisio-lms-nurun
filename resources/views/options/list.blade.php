@extends('layouts.app')

@section('title','Opciones')
@section('cta')
  <a href="{{ route('options.create') }}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Opción</a>
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
                            <td><a href="{{ action('QuestionsController@show', $option->question->id) }}">{{ $option->question->content }}</a></td>
                            <td><a href="{{ action('OptionsController@show', $option->id) }}">{{ $option->content }}</a></td>
                            <td>{{ ($option->score == 1) ? 'Correcta' : 'Incorrecta' }}</td>
                            <td>
                                {!! Form::open(['method'=>'delete','route'=>['options.destroy',$option->id],'style'=>'display:inline;']) !!}
                                  <a href="#" class="btn btn-danger btn_delete">Eliminar</a>
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
    