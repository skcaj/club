
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
<meta name="author" content="Miguel Zambrano">
<meta name="keyword" content="Sistema ventas Laravel Vue Js, Sistema compras Laravel Vue Js">
 <link rel="shortcut icon" href="img/favicon.png">
 <meta name="csrf-token" content="{{ csrf_token() }}">
<title>Miguel Zambrano IT</title>

<!--
<link href="css/style.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.min.css" rel="stylesheet">
-->





<link href="css/mix.css" rel="stylesheet">

</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show ">

<div id="app">
            <header class="app-header navbar">
                <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
                <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">
                <img class="navbar-brand-full" src="img/logo.png" width="89" height="25" alt="CoreUI Logo">
                <img class="navbar-brand-minimized" src="img/favicon.png" width="30" height="30" alt="CoreUI Logo">
                </a>
                <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
                <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="nav navbar-nav d-md-down-none">
                <li class="nav-item px-3">
                <a class="nav-link" href="#">Escritorio</a>
                </li>
                <li class="nav-item px-3">
                <a class="nav-link" href="#">Users</a>
                </li>
                <li class="nav-item px-3">
                <a class="nav-link" href="#">Configuraciones</a>
                </li>
                </ul>
                
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item d-md-down-none">
                        <a class="nav-link" href="#" data-toggle="dropdown">
                            <i class="icon-bell"></i>
                            <span class="badge badge-pill badge-danger">5</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header text-center">
                                <strong>Notificaciones</strong>
                            </div>
                            <a class="dropdown-item" href="#">
                                <i class="fa fa-envelope-o"></i> Ingresos
                                <span class="badge badge-success">3</span>
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fa fa-tasks"></i> Ventas
                                <span class="badge badge-danger">2</span>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                                <span class="d-md-down-none">{{Auth::user()->usuario}} </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header text-center">
                                    <strong>Cuenta</strong>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Perfil</a>
                                <a class="dropdown-item" href="{{route('logout')}}" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-lock"></i> Cerrar sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                     </li>
                </ul>


                
            </header>
            
<div class="app-body">
@if(Auth::check())

    @if(Auth::user()->id_rol==1)
    @include('menus.menuadministrador')
    @elseif(Auth::user()->id_rol==2)
    @include('menus.menudirector')
    @elseif(Auth::user()->id_rol==3)
    @include('menus.menuconsejero')
    @elseif(Auth::user()->id_rol==4)
    @include('menus.menuconquisador')
        
    @endif
@endif


    @yield('contenido')
</div>
</div>
<footer class="app-footer">
<div>
<a href="">MiguelZIT</a>
<span>© 2019 Creaciones.</span>
</div>
<?php
    function contador()
    {
        $archivo = "contador.txt"; //el archivo que contiene en numero
        $f = fopen($archivo, "r"); //abrimos el archivo en modo de lectura
        if($f)
        {
            $contador = fread($f, filesize($archivo)); //leemos el archivo
            $contador = $contador + 1; //sumamos +1 al contador
            fclose($f);
        }
        $f = fopen($archivo, "w+");
        if($f)
        {
            fwrite($f, $contador);
            fclose($f);
        }
        return $contador;
    }
    $visitante = contador(); 
?>
<div class="ml-auto" > 

<span>Contador de  Visitas: </span>
<a href=""><?  echo $visitante; ?></a>
</div>
<div class="ml-auto">
<span>Creador</span>

<a href="#">Miguel Zambrano</a>
</div>
</footer>

    <script src="js/app.js"></script>
    <script src="js/mix.js"></script>
    <script type="text/javascript">
    
      
	$('#demoDate').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		todayHighlight: true
	});
   
  </script>
</body>
</html>