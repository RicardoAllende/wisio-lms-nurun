<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">Admin</strong>
                            </span> <span class="text-muted text-xs block">Menú<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Ajustes</a></li>
                        <li><a href="#">Cerrar Sesión</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="<?php echo e(isActiveRoute('main')); ?>">
                <a href="<?php echo e(url('/users')); ?>"><i class="fa fa-users"></i> <span class="nav-label">Usuarios</span></a>
            </li>
            <li class="<?php echo e(isActiveRoute('main')); ?>">
                <a href="<?php echo e(url('/categories')); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Categorías</span></a>
            </li>
            <li class="<?php echo e(isActiveRoute('main')); ?>">
                <a href="<?php echo e(url('/courses')); ?>"><i class="fa fa-list-ul"></i> <span class="nav-label">Cursos</span></a>
            </li>

        </ul>

    </div>
</nav>
