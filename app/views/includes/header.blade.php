<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		      	<span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="{{ URL::route('home') }}">{{trans('pages.name')}}</a>
		    </div>
		    
		     
    <ul class="nav navbar-nav">
	@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
	    
	    <li {{ (Request::is('users*') ? 'class="active"' : '') }}><a href="{{ URL::to('/users') }}">{{trans('pages.users')}}</a></li>
	    <li {{ (Request::is('groups*') ? 'class="active"' : '') }}><a href="{{ URL::to('/groups') }}">{{trans('pages.groups')}}</a></li>
	@endif
	@if (Sentry::check() && Sentry::getUser()->hasAccess('users'))
	    
	    <li {{ (Request::is('reportes*') ? 'class="active"' : '') }}><a href="{{ URL::to('/fechas') }}">{{trans('pages.reporte')}}</a></li>
	    <li {{ (Request::is('agregar*') ? 'class="active"' : '') }}><a href="{{ URL::to('/cuentas') }}">{{trans('pages.agregar')}}</a></li>
	@endif
	</ul>
	<ul class="nav navbar-nav navbar-right">
	@if (Sentry::check())
		<li {{ (Request::is('users/show/' . Session::get('userId')) ? 'class="active"' : '') }}><a href="{{ URL::to('users') }}/{{ Session::get('userId') }}">{{ Session::get('email') }}</a></li>
		<li><a href="{{ URL::to('logout') }}">{{trans('pages.logout')}}</a></li>
	@else
		<li {{ (Request::is('login') ? 'class="active"' : '') }}><a href="{{ URL::to('login') }}">{{trans('pages.login')}}</a></li>

	@endif
     </ul>    
</nav> <!-- ./ navbar -->
