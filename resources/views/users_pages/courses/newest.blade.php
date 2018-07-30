<!-- Cursos recientes -->
         <div class="row cf pad-left3 pad-right2 padtop15">
            <div class="col s6 l8">
               <hr class="line2"/>
            </div>
            <div class="col s6 l4">
               <h2 class="subtitulo txt-blanco" id="recent-courses">Cursos Recientes</h2>
            </div>
            <div class="row">


              @foreach($courses as $course)
              <div class="col s6 l3">
                 <div class="card card-academia z-depth-0">
                    <div class="card-content">
                       <span class="categoria-academia">{{ $course->category->name }}</span>
                      <div class="iconcourse"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img"></div>
                       <h4 class="titulo-academia"> {{ $course->name }} </h4>
                       <div class="leer-mas">
                         @if(Auth::check())
                          <a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Cursos_Ver mas_(Nombre del curso)'});"
                           href="{{ route('student.show.course',[$ascription->slug, $course->slug]) }}">Ver más</a>
                         @else
                         <a onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Cursos_Ver_mas_{{ $course->slug }}'});"
                          href="{{ route('student.show.course',[$ascription->slug, $course->slug]) }}">Ver más</a>
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
                  <a href="{{ route('student.own.courses',$ascription->slug )}}">Ver todos los cursos</a>
                @else
                  <a href="{{ route('student.home', $ascription->slug) }}" id="btnAllCourses" >Ver todos los cursos</a>
                @endif
                  <hr class="line4"/>
              </div>
            </div>


         </div>
