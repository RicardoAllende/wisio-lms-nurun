<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                @if (Auth::check())
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ Auth::User()->firstname }}</strong>
                            </span> <span class="text-muted text-xs block">Menú<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Ajustes</a></li>
                        <li><a href="{{ route('logout') }}">Cerrar Sesión</a></li>
                    </ul>
                </div>
                @endif
                <div class="logo-element">
                    S
                </div>
                
            </li>
            @if (Auth::check())
                <li class="{{ isActiveRoute('main') }}">
                    <a href="{{ url('/users') }}"><i class="fa fa-users"></i> <span class="nav-label">Usuarios</span></a>
                </li>
                <li class="{{ isActiveRoute('main') }}">
                    <a href="{{ url('/categories') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Categorías</span></a>
                </li>
                <li class="{{ isActiveRoute('main') }}">
                    <a href="{{ url('/courses') }}"><i class="fa fa-list-ul"></i> <span class="nav-label">Cursos</span></a>
                </li>
                <li class="{{ isActiveRoute('main') }}">
                    <a href="{{ route('form.upload.questions') }}"><i class="fa fa-list-ul"></i> <span class="nav-label">Subir preguntas</span></a>
                </li>
                <li class="{{ isActiveRoute('main') }}">
                    <a href="{{ route('quizzes.index') }}"><i class="fa fa-list-ul"></i> <span class="nav-label">Quizzes</span></a>
                </li>
            @else
                <li class="{{ isActiveRoute('main') }}">
                    <a href="{{ url('/login') }}"><i class="fa fa-users"></i> <span class="nav-label">Iniciar sesión</span></a>
                </li>
            @endif
        </ul>

    </div>
</nav>
