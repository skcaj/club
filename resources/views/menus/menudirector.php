<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="nav-icon icon-speedometer"></i> Escritorio</a>
                    </li>
                    <li class="nav-title">
                        Mantenimiento
                    </li>
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link active" href="#"><i class="nav-icon fa fa-users fa-lg "></i> Unidades</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link active" href="#"><i class="nav-icon fa fa-user-circle fa-lg"></i> Conquistadores</a>
                    </li>
                   
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-money fa-lg"></i> Pagos</a>
                        <ul class="nav-dropdown-items">
                            
                            <li @click="menu=3"class="nav-item">
                                <a class="nav-link" href="#"><i class="nav-icon fa fa-list-alt fa-lg"></i> Tipos</a>
                            </li>
                            
                        </ul>
                    </li>

                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
 </div>