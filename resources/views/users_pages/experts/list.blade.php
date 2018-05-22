@section('title')
Expertos
@stop
@extends('users_pages.master')
@section('body')
  <div class="row pad-left3">
    <h2 class="recientes">Expertos</h2>
    @foreach($experts as $expert)
    <div class="col s12 l3 ">
               <div class="card z-depth-0 white ">
                  <div class="card-content expertoscard">
                     <div class="expertostitulo">{{ $expert->name }}</div>
                      <div class="col s12">
                          <img src="{{ $expert->getMainImgUrl() }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                      <div class="expertosparticipacion">
                        <p class="upper">Participa en:</p>
                        <ul class="browser-default">
                            @foreach($expert->modules as $module)
                            <li>{{ $module->name }}</li>
                            @endforeach
                        </ul>
                      </div>

                    <div class="leer-masmodulos">
                      @if(Auth::check())
                        <a href="{{ route('student.show.expert',[Auth::user()->ascription()->slug,$expert->slug]) }}">Ver más</a>
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
  cambiarItem("expertos");
</script>
@stop
