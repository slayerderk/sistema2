<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Ventas|">
    <meta name="author" content="Junior Y. Campos Alvarez ">
    <meta name="keyword" content="Sistema de Ventas">
    <link rel="shortcut icon" href="img/gallery/negrito_icono.png">
    <!-- Id for Channel Notification -->   
    <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : ''}}">  

    <title>SisVentas-laravel56</title>
    <!-- Protege contra ataques maliciosos -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="js/Chart.min.js">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"> -->

    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Botones de:  -->
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Escritorio</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Configuraciones</a>
            </li>
        </ul>
        <!-- fin Botones -->
        
        <ul class="nav navbar-nav ml-auto">
            <notification :notifications="notifications"></notification>
            <!-- NOmbre y logout sesion -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="img/avatars/1.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                    <span class="d-md-down-none">{{Auth::user()->usuario}} </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <a class="dropdown-item" href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesión</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
            <!-- fin ** -->
        </ul>
    </header>

    <div class="app-body">
        
        @if(Auth::check())
            <!--Si el uaurio autenticado tiene el rol 1, entonces es Administrador-->
            @if (Auth::user()->idrol == 1)
                <!--OPciones del Menu -->
                @include('plantilla.sidebaradministrador')
            @elseif (Auth::user()->idrol == 2)
                @include('plantilla.sidebarvendedor')
            @elseif (Auth::user()->idrol == 3)
                @include('plantilla.sidebaralmacenero')
            @else

            @endif

        @endif
            <!-- Contenido Principal -->
            @yield('contenido')
            <!-- /Fin del contenido principal -->
    </div>   
    </div>
    <footer class="app-footer">
        <span><a href="https://www.facebook.com/junior.camposalvarez"></a>&copy;2018. Derechos Reservados</span>
        <span class="ml-auto">Desarrollado por <a href="https://www.facebook.com/junior.camposalvarez" target="_blank">Junior Campos Alvarez</a></span>
    </footer>
    
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>

</html>