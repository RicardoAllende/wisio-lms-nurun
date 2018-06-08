<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                @if (Auth::check())
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ Auth::User()->firstname }} {{ Auth::User()->lastname }}</strong>
                            </span> <span class="text-muted text-xs block">Menú<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('logout') }}">Cerrar Sesión</a></li>
                    </ul>
                </div>
                @endif
                <div class="logo-element">
                    A
                </div>
                
            </li>
            @if (Auth::check())
                @if (Auth::user()->isAdmin())
                    <!--<li class="isActiveRoute('main')">
                        <a href="{{ route('users.index') }}"><i class="fa fa-users"></i> <span class="nav-label">Usuarios</span></a>
                    </li>-->
                    <li>
                        <a href=""><i class="fa fa-users"></i> <span class="nav-label">Usuarios</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('users.index').'?type=doctors'}}">Todos los médicos</a></li>
                            <li><a href="{{ route('users.create') }}">Crear usuario</a></li>
                            <li><a href="{{ route('users.index').'?type='.config('constants.roles.admin') }}">Administradores</a></li>
                            <li><a href="{{ route('users.index') }}">Todos los usuarios</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href=""><i class="	fa fa-line-chart"></i> <span class="nav-label">Reportes</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('list.ascriptions.report')}}">Adscripción</a></li>
                            <li><a href="{{ route('list.courses.report')}}">Curso</a></li>
                            <li><a href="{{ route('list.users.report') }}">Usuario</a></li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('ascriptions.index') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Adscripciones</span></a>
                    </li>
                    <li><a href="{{ route('list.diplomados') }}"><i class="fa fa-certificate" ></i><span>Diplomados</span> </a></li>
                    <li class="">
                        <a href="{{ route('categories.index') }}"><i class="fa fa-folder"></i> <span class="nav-label">Categorías</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('courses.index') }}"><i class="fa fa-table"></i> <span class="nav-label">Cursos</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('modules.index') }}"><i class="fa fa-sitemap"></i> <span class="nav-label">Módulos</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('evaluations.index') }}"><i class="fa fa-edit"></i> <span class="nav-label">Evaluaciones</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('specialties.index') }}"><i class="fa fa-qrcode"></i> <span class="nav-label">Especialidades</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('experts.index') }}"><i class="fa fa-qrcode"></i> <span class="nav-label">Expertos</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('templates.index') }}"><i class="fa fa-file-pdf-o"></i> <span class="nav-label">Plantillas para certificados</span></a>
                    </li>
                @endif
                @if (Auth::user()->isStudent())
                    <li class="">
                        <a href=""><i class="fa fa-laptop"></i> <span class="nav-label">Mis cursos</span></a>
                    </li>
                    <li class="">
                        <a href=""><i class="fa fa-user-circle"></i> <span class="nav-label">Actualizar datos</span></a>
                    </li>
                    <li class="">
                        <a href=""><i class="fa fa-file-pdf-o"></i> <span class="nav-label">Certificados</span></a>
                    </li>
                    <li class="">
                        <a href=""><i class="fa fa-files-o"></i> <span class="nav-label">Recomendaciones de cursos</span></a>
                    </li>
                @endif
                <li class="">
                    <a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> <span class="nav-label">Cerrar sesión</span></a>
                </li>
            @else
                <li class="">
                    <a href="/"><i class="fa fa-sign-in"></i> <span class="nav-label">Iniciar sesión</span></a>
                </li>
            @endif
        </ul>

    </div>
</nav>
