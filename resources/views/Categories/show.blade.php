@extends('layouts.app')

@section('title','Categoría '.$category->name )
@section('cta')
  <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Categoría</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="widget lazur-bg p-xl">
            <div class="row">
                <div class="col-lg-6">
                    <center>
                        <img alt="image" class="m-t-xs img-responsive" style="width: 30%; height:30%;" src="{{ $category->getMainImgUrl() }}">
                    </center>
                </div>
                <div class="col-lg-6"><br>
                    <h2>
                    {{ $category->name }}
                    </h2>
                    <h3>
                    {{ $category->description }}
                    </h3>
                </div>
            </div>
                
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
@endsection