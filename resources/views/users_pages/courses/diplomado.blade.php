@section('title')
  Seleccionar sección
@stop

@extends('users_pages.master')

@section('body')
  <div class="row pad-left3">
    <div class="col s6 l7">
      <hr class="line"/>
    </div>
    <div class="col s6 l5">
      <h2 class="recientes">Seleccione la sección a la que quiere ingresar</h2>
    </div>
      @foreach($ascriptions as $ascription)
      <div class="col s12 l4 ascriptionSelector" data-slug="{{ $ascription->slug }}" data-url="{{ route('student.home', $ascription->slug) }}" >
        <div class="card z-depth-0 white ">
          <div class="card-content cursoscard">
            <span class="categoria-academia">{{ $ascription->name }}</span>
            <div class="iconcourse"><img src="{{ $ascription->getMainImgUrl() }}" class="responsive-img"></div>
            <div class="titulo-academia2"> {{ $ascription->name }}</div>
            <div class="modulos">Contiene {{ $ascription->courses()->count() }} cursos</div>
          </div>
        </div>
      </div>
      @endforeach
  </div>
@stop

@section('extrajs')
  <script>
    $('.ascriptionSelector').click(function(){
      var url = $(this).data("url");
      window.location.href = url;
    });
  </script>
@endsection