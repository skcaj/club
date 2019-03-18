<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#">
                        <i class="nav-icon icon-speedometer"></i> Escritorio</a>
                    </li>
                    <li class="nav-title">
                        Mantenimiento
                    </li>
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link " href="#"><i class="nav-icon fa fa-users fa-lg "></i> Unidades</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link " href="#"><i class="nav-icon fa fa-user-circle fa-lg"></i> Conquistadores</a>
                    </li>
                   
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class=" nav-icon fa fa-money fa-lg"></i> Pagos</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=4"class="nav-item">
                                <a class="nav-link" href="#"><i class=" nav-icon icon-calculator"></i> Registro</a>
                            </li>
                            <li @click="menu=3"class="nav-item">
                                <a class="nav-link" href="#"><i class="nav-icon fa fa-list-alt fa-lg"></i> Tipos</a>
                            </li>
                            <li @click="menu=5"class="nav-item">
                                <a class="nav-link" href="#"><i class=" nav-icon fa fa-list-alt fa-lg"></i> Filtrar </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon icon-basket"></i> Cuotas</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=6"class="nav-item">
                                <a class="nav-link" href="#"><i class="nav-icon icon-basket-loaded"></i> Registro</a>
                            </li>
                            <li @click="menu=6"class="nav-item">
                                <a class="nav-link" href="#"><i class="nav-icon icon-notebook"></i> Clientes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon icon-people"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=7"class="nav-item">
                                <a class="nav-link" href="#"><i class="nav-icon icon-user"></i> Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a @click="menu=8"class="nav-link" href="#"><i class="nav-icon icon-user-following"></i> Roles</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon icon-pie-chart"></i> Reportes</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=9"class="nav-item">
                                <a class="nav-link" href="#"><i class="nav-icon icon-chart"></i> Reporte Ingresos</a>
                            </li>
                            <li @click="menu=10"class="nav-item">
                                <a class="nav-link" href="#"><i class="nav-icon icon-chart"></i> Reporte Ventas</a>
                            </li>
                        </ul>
                    </li>
                    <li @click="menu=11"class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon icon-book-open"></i> Ayuda <span class="badge badge-danger">PDF</span></a>
                    </li>
                    <li @click="menu=12"class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>