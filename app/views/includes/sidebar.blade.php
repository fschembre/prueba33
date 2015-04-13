<!-- Topbar -->
<div class="menu">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="navbar-collapse collapse">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home">Control de cuentas</a>
        </div>
    <!-- Top Menu Items -->
        <ul class="nav navbar-left top-nav">                               
        @if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
            <ul class="nav navbar-nav navbar-left">        
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Agregar <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">                
                <li><a href="vloteria">Lotería</a></li>            
                <li class="divider"></li>
                <li><a href="preimpresos">Preimpresos</a></li>
              </ul>
            </li>
          </ul>

        @endif
        </ul>
        

        <ul class="nav navbar-right top-nav">                               
        @if (Sentry::check())
            <li class="dropdown">                                                
        <!--                <li {{ (Request::is('users/show/' . Session::get('userId')) ? 'class="active"' : '') }}><a href="{{ URL::to('users') }}/{{ Session::get('userId') }}">{{ Session::get('email') }}</a></li>
        -->                
                <li><a href="{{ URL::to('logout') }}">{{trans('pages.logout')}}</a></li>
                @else
                <li {{ (Request::is('login') ? 'class="active"' : '') }}><a href="{{ URL::to('login') }}">{{trans('pages.login')}}</a></li>                                        
            </li>
        @endif
        </ul>           
    </nav>
</div>

<!-- Sidebar -->
@if (Sentry::check() && Sentry::getUser()->hasAccess('users'))
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">        
          <li class="active">
                    <a href="home"><i class="fa fa-fw fa-dashboard"></i>.... Principal</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#ventas"><i class="fa fa-fw fa-list-ol"></i>.... Ventas <i class="fa fa-fw fa-caret-down"></i></a>

                    <ul id="ventas" class="collapse">
                        <li>
                            <a href="vFechas">Por fecha</a>
                        </li>
                        <li>
                            <a href="vAgencias">Por Agencia</a>
                        </li>
                         <li>
                            <a href="vProductos">Por Producto</a>
                        </li>
                         <li>
                            <a href="vPreimpresos">Preimpresos</a>
                        </li>
                         <li>
                            <a href="vCustom">Customizar</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#reportes"><i class="fa fa-file-text"></i>  Reportes <i class="fa fa-fw fa-caret-down"></i></a>

                    <ul id="reportes" class="collapse">
                        <li>
                            <a href="rCostos">Gastos</a>
                        </li>
                        <li>
                            <a href="rGanancia">Ganancia</a>
                        </li>
                        <li>
                            <a href="rResumen">Resumen</a>
                        </li>                         
                    </ul>
                </li>

            <!--
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#reportes"><i class="fa fa-fw fa-file"></i>.... Reportes <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="reportes" class="collapse">
                        <li>
                            <a href="rFechas">Por fecha</a>
                        </li>
                       
                    </ul>
                </li>  
            -->   
    </ul>
</div>
@endif            