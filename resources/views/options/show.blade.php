@extends('layouts.app')

@section('title','Respuestas')
@section('cta')
  <a href="/options/{{ $option->id }}/edit" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Respuesta</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de Respuesta</h5>
            </div>
		<div class="contact-box">
            <div class="col-sm-12">
                <h3><strong>{{ $option->content }}</strong></h3>
                <p> Pregunta: {{ $option->question->name }}</p>

            </div>
            <div class="clearfix">
                <a href="{{ route('questions.show', $option->question->id) }}" class='btn btn-info'>{{ $option->question->name }}</a>
            </div>
                
        </div>

        </div>
      </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection