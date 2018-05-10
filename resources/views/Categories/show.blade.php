@extends('layouts.app')

@section('title','Categorías')
@section('cta')
  <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Categoría</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de Categoria</h5>
                
            </div>

		<div class="contact-box">
            
            <div class="col-sm-4">
                <div class="text-center">
                    <img alt="image" class="m-t-xs img-responsive" src="{{ $category->getMainImgUrl() }}">
                    <!--<div class="m-t-xs font-bold">Usuario</div>-->
                </div>
            </div>
            <div class="col-sm-8">
                <h3><strong>{{ $category->name }}</strong></h3>
                <p> {{ $category->description }}</p>
            </div>

            <div class="clearfix"></div>
                
        </div>

        @if ($category->hasCourses())
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Curso</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($category->courses as $course) 
                            <tr>
                            <td><a href="{{ action('CoursesController@show', $course->id) }}">{{ $i }}</a></td>
                            <td><a href="{{ action('CoursesController@show', $course->id) }}">{{ $course->name }}</a></td>
                            <td>{{$course->start_date}}</td>
                            <td>{{$course->end_date}}</td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h3><strong>Ningún curso está asociado a esta categoría</strong></h3><br>
        @endif

        </div>
      </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection