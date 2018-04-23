@extends('layouts.app')

@section('title','Answers')
@section('cta')
  <a href="/categories/create" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Respuesta</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Respuestas</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>Respuesta</th>
                            <th>Quiz</th>
                            <th>Pregunta</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($answers as $answer)
                            <tr>
                              <td><a href="{{ action('AnswersController@show', $answer->id) }}">{{ $answer->content }}</a></td>
                              <td><a href="{{ action('QuizzesController@show', $answer->question->quiz->id) }}"> {{ $answer->question->quiz->name }}</a></td>
                              <td><a href="{{ action('QuestionsController@show', $answer->question->id) }}">{{ $answer->question->content }}</a></td>
                              <td>
                                  {!! Form::open(['method'=>'delete','route'=>['answers.destroy',$answer->id],'style'=>'display:inline;']) !!}
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

<script src="js/sweetalert2.min.js"></script>
<script src="js/method_delete_f.js"></script>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css">
@endsection
    