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
                            <li><a href="{{ route('users.index') }}">Listado de usuarios</a></li>
                            <li><a href="{{ route('users.not.validated') }}">Usuarios con cédula no validada</a></li>
                            <li><a href="{{ route('users.create') }}">Crear usuario</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href=""><i class="	fa fa-line-chart"></i> <span class="nav-label">Reportes</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('excel.reports')}}">Reportes en Excel</a></li>
                            <li><a href="{{ route('list.ascriptions.report')}}">Adscripción</a></li>
                            <li><a href="{{ route('list.courses.report')}}">Curso</a></li>
                            <li><a href="{{ route('list.users.report') }}">Usuario</a></li>
                            <li><a href="{{ route('list.diploma.report') }}">Diplomado</a></li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('ascriptions.index') }}"><i class="fa fa-th-large"></i><span class="nav-label">Adscripciones</span></a>
                    </li>
                    <li>
                        <a href=""><i class="	fa fa-line-chart"></i> <span class="nav-label">Diplomados</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('diplomas.index')}}">Mostrar diplomados</a></li>
                            <li><a href="{{ route('diplomas.create')}}">Crear diplomado</a></li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('list.templates') }}"><i class="fa fa-th-large"></i><span class="nav-label">Pruebas de certificados</span></a>
                    </li>
                    <li>
                        <a href="{{ route('invite.form') }}"><i class="fa fa-envelope-o"></i><span class="nav-label">Crear enlace de invitación</span></a>
                    </li>
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
                        <a href="{{ route('change.admin.password') }}"><i class="fa fa-lock"></i> <span class="nav-label">Cambiar contraseña de administrador</span></a>
                    </li>
                    <li>
                        <a href=""><i class="glyphicon glyphicon-calendar"></i> <span class="nav-label">Notificaciones</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('notifications.list.users') }}">Usuarios con notificaciones</a></li>
                            <li><a href="{{ route('call.list')}}">Lista de usuarios por llamar</a></li>
                            <li><a href="{{ route('form.settings') }}">Configuraciones</a></li>
                        </ul>
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
