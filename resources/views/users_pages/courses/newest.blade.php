<!-- Cursos recientes -->
@inject('newest','App\Http\Controllers\AdminControllers\CoursesController')
         <div class="row cf pad-left3 pad-right2">
            <div class="col s6 l9">
               <hr class="line2"/>
            </div>
            <div class="col s6 l3">
               <h2 class="subtitulo txt-blanco">Cursos Recientes</h2>
            </div>
            <div class="row">


              @foreach($newest->newestCourses() as $course)
              <div class="col s6 l3">
                 <div class="card card-academia z-depth-0">
                    <div class="card-content">
                       <span class="categoria-academia">{{ $course->categories->first()->name }}</span>
                      <div class="iconcourse"><img src="{{ $course->categories->first()->getMainImgUrl() }}" class="responsive-img"></div>
                       <span class="titulo-academia"> {{ $course->name }} </span>
                       <div class="leer-mas">
                         @if(Auth::check())
                           <a href="{{ route('student.show.course',[Auth::user()->ascription()->slug,$course->slug]) }}">Ver más</a>
                         @else
                           <a href="{{ route('student.show.course',['invitado',$course->slug]) }}">Ver más</a>
                         @endif
                           <hr class="line3"/>
                       </div>
                    </div>
                 </div>
              </div>
              @endforeach
            </div>

            <div class="row">
              <div class="col s12 l4 offset-l4 center cursos">
                @if(Auth::check())
                  <a href="{{ route('student.own.courses',Auth::user()->ascription()->slug )}}">Ver todos los cursos</a>
                @else
                  <a href="{{ route('student.own.courses','invitado' )}}">Ver todos los cursos</a>
                @endif
                  <hr class="line4"/>
              </div>
            </div>


         </div>
