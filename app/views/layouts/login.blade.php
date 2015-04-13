<html>
<head>
	@include('includes.head')
<style>
container-fluid 
{
    background-color: #FFFF1F;
}
</style>
</head>

	<body>		

<div id="wrapper">		
			<!-- Sidebar Menu -->							
			@include('includes.header')	
			<!-- Container -->
			
	            <div class="container-fluid">
												
						<!-- Notifications -->
							@include('layouts/notifications')
						<!-- ./ notifications -->					
						<!-- Content -->
							@yield('content')
						<!-- ./ content -->						
						
					
					<?php for($i=0; $i <=100; $i++){echo "<br>";} ?> 

				</div><!-- ./ container-fluid -->
			
	    </div><!-- /#wrapper -->
		@include('includes.footer')			











	</body>
</html>
