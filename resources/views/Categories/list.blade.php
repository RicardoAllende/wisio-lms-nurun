@extends('layouts.app')

@section('title','Categorías')
@section('cta')
  <a href="{{route('categories.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Categoría</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          Categorías
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>A continuación aparecen todos las categorias que se encuentran en el sistema</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Categoria </th>
                            <th>Descripción</th>
                            <th>Fecha de creación</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($categories as $category)
                              <tr>
                              <td><a href="{{ route('categories.show', $category->id) }}">{{ $i }}</a></td> @php $i++; @endphp
                              <td><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></td>
                              <td>{{ $category->description }}</td>
                              <td>{{ $category->created_at }}</td>
                              <td>
                                  {!! Form::open(['method'=>'DELETE','route'=>['categories.destroy',$category->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                     <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
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
     
