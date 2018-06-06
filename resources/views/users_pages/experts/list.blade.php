@section('title')
Expertos
@stop
@extends('users_pages.master')
@section('body')
  <div class="row pad-left3">
    <h2 class="recientes">Expertos</h2>
    <div class="row">
      <form class="col s12" id="formSearch" name="formSearch" method="get">
        <div class="row">
          <div class="input-field col s6 l4">
            <input id="name" value="{{ $name }}" name="name" type="text" placeholder="Nombre del experto" >
          </div>
          <div class="input-field col s6 l4">
            <select name="specialty" id="specialty">
              @if($specialty != '')
                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
              @else
                <option value="">Filtrar por especialidad</option>
              @endif
              @inject('controller','App\Http\Controllers\Users_Pages\ExpertsController')
              @foreach($controller->getSpecialties() as $specialty)
                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="input-field col s6">
            <button id="submit" class="btnAcademia waves-effect waves-light">Buscar</button>
            <a href="{{ URL::current() }}" class="btnAcademia waves-effect waves-light" >Limpiar</a>
            <!--<i class="material-icons prefix" id="submit">search</i>
            <input class="material-icons prefix" type="submit">-->
          </div>
        </div>
      </form>
    </div>
    @foreach($experts as $expert)
    <div class="col s12 l3 ">
               <div class="card z-depth-0 white">
                  <div class="card-content expertoscard">
                     <div class="expertostitulo center">{{ $expert->name }}</div>
                      <div class="col s12 center">
                          <img src="{{ $expert->getMainImgUrl() }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                      <div class="expertosparticipacion">
                        <p class="upper center">Participa en:</p>
                        <ul class="browser-default ">
                            @foreach($expert->modules->slice(0,5) as $module)
                            <li>{{ $module->name }}</li>
                            @endforeach
                        </ul>
                      </div>

                    <div class="leer-masmodulos">
                      @if(Auth::check())
                        <a href="{{ route('student.show.expert',[$ascription->slug,$expert->slug]) }}">Ver más</a>
                      @else
                        <a href="{{ route('student.show.expert',['invitado',$expert->slug]) }}">Ver más</a>
                      @endif

                         <hr class="line3"/>
                     </div>
                  </div>
               </div>
            </div>
        @endforeach

  </div>
@stop

@section('extrajs')
<script>
  $('select').material_select();
  $('#submit').click(function(){
    $('#formSearch').submit();
  });

  $('#name').keydown(function(e){
    if(e.which == 13) {
      $('#formSearch').submit();
    }
  });

  $('#specialty').change(function(){
    if( $('#specialty').val() != "" ){
      $('#formSearch').submit();
    }
  });

  cambiarItem("expertos");
</script>
@stop
