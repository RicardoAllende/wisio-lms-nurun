@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
  <a href="/users/{{ $user->id }}/edit" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Usuario</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de Usuario</h5>
                
            </div>

		<div class="contact-box">
            
            <div class="col-sm-4">
                <div class="text-center">
                    <img alt="image" class="img-circle m-t-xs img-responsive" src="/{{ $user->photo }}">
                    <!--<div class="m-t-xs font-bold">Usuario</div>-->
                </div>
            </div>
            <div class="col-sm-8">
                <h3><strong>{{ $user->firstname }} {{ $user->lastname }}</strong></h3>
                <h3>{{ $user->username }}</h3>
                <p><i class="fa fa-envelope"></i> {{ $user->email }}</p>
                <p><i class="fa fa-{{ $user->sex }}"></i> {{ $user->sex }}</p>
                <p><i class="fa fa-birthday-cake"></i> {{ $user->birth_day }}</p>
                
                
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