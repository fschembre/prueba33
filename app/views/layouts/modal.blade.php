<html ng-app="modalTest">
<head>
	@include('includes.head')
</head>
	<body>								
		<div id="wrapper" align="left">		
			<!-- Sidebar Menu -->							
			@include('includes.sidebar')	
			<!-- Container -->
			<div id="page-wrapper">
	            <div class="container-fluid">
					@if (Sentry::check())									
						<!-- Notifications -->
							@include('layouts/notifications')
						<!-- ./ notifications -->					
						<!-- Content -->
							@yield('content')
						<!-- ./ content -->
						<!-- Scripts -->
							
							
						
						<!-- ./ scripts -->
					@endif													
				</div><!-- ./ container-fluid -->
			</div><!-- ./ page-wrapper -->				
	    </div><!-- /#wrapper -->
		@include('includes.footer')			
	</body>
</html>
