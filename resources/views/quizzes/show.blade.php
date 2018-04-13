@extends('layouts.app')

@section('title','Categorías')
@section('cta')
  <a href="/quizzes/{{ $quiz->id }}/edit" class="btn btn-primary "><i class='fa fa-edit'></i> Editar quiz</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos del Quiz</h5>
                
            </div>

		<div class="contact-box">
            
            <div class="col-sm-4">
                <div class="text-center">
                </div>
            </div>
            <div class="col-sm-8">
                <h3><strong>{{ $quiz->quiz }}</strong></h3>
                <h3><strong> Tipo: {{ $quiz->type }}</strong></h3>
                <p> {{ $quiz->created_at }}</p>
                
                
                
            </div>
            <div class="clearfix"></div>
                
        </div>

        </div>
      </div>
	</div>
</div>
@endsection