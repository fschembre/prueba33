<div class="menu">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
        @if (Sentry::check() && Sentry::getUser()->hasAccess('users'))
            <ul class="nav navbar-nav navbar-left">        
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Agregar <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="cuentas">Registos</a></li>
                <li><a href="preimpresos">Preimpresos</a></li>            
                <li class="divider"></li>
                <li><a href="#">Usuarios</a></li>
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
        @if (Sentry::check() && Sentry::getUser()->hasAccess('users'))

    @endif            
    </nav>
</div>