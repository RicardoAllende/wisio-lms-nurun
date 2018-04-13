@extends('layouts.app')

@section('title','Cursos')
@section('cta')
  <a href="/courses/{{ $course->id }}/edit" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Curso</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de Curso</h5>
                
            </div>

		<div class="contact-box">
            
            <div class="col-sm-4">
                <div class="text-center">
                    <img alt="image" class="m-t-xs img-responsive" src="/{{ $course->featured_image }}">
                    <!--<div class="m-t-xs font-bold">Curso</div>-->
                </div>
            </div>
            <div class="col-sm-8">
                <h3><strong>{{ $course->name }}</strong></h3>
                <p> {{ $course->description }}</p>
                
                
                
            </div>
            <div class="clearfix"></div>
                
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