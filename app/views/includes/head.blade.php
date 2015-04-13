	<meta charset="UTF-8" />
	<title> 
		@section('title') 
		@show 
	</title>
<!-- Bootstrap -->
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">	
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">		
<!--jQuery-->
	<!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script> -->
	<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.11.1.min.js"></script>	
<!--DataTables CSS-->
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10-dev/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/dataTables.bootstrap.js"></script>
<!-- DateRangePicker -->
	<link rel="stylesheet" type="text/css" media="all" href="assets/daterangepicker/daterangepicker-bs3.css" />
	<script type="text/javascript" src="assets/daterangepicker/moment.js"></script>
	<script type="text/javascript" src="assets/daterangepicker/daterangepicker.js"></script>
<!-- Dashboard -->
	<link href="assets/dashboard/css/sb-admin.css" rel="stylesheet">   	
	<link href="assets/dashboard/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

<!-- Graphics CSS -->
	<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.5.1.css">   
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="http://cdn.oesmith.co.uk/morris-0.5.1.min.js"></script>
 <!-- bootbox code -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootbox.js"></script>

	<style>
			table.dataTable thead th {
			    position: relative;
			    background-image: none !important;
			}
			 
			table.dataTable thead th.sorting:after,
			table.dataTable thead th.sorting_asc:after,
			table.dataTable thead th.sorting_desc:after {
			    position: absolute;
			    top: 12px;
			    right: 8px;
			    display: block;
			    font-family: FontAwesome;
			}
			
			td {
				font-size: 11pt;
			}
			td { color: black; }
			td.positive { color: green; }
			td.negative { color: red; }
		
		/* Header cells */			
			thead {
				
				color: #00000;
				font-size: 12;
				padding: 5;
				font-weight: bold;
			}
			tfoot {
				
				color: #00000;
				font-size: 12;
				padding: 5;
				font-weight: bold;
			}

			.esquina {		
				float: left;		
				color: #00000;
				font-size:11;					
			}

			body{margin:40px;}


			.btn-circle {
			  width: 20px;
			  height: 20px;
			  text-align: center;
			  padding: 6px 0;
			  font-size: 10px;
			  line-height: 1.428571429;
			  border-radius: 15px;
			}
			.btn-circle.btn-lg {
			  width: 50px;
			  height: 50px;
			  padding: 10px 16px;
			  font-size: 18px;
			  line-height: 1.33;
			  border-radius: 25px;
			}
			.btn-circle.btn-xl {
			  width: 70px;
			  height: 70px;
			  padding: 10px 16px;
			  font-size: 24px;
			  line-height: 1.33;
			  border-radius: 35px;
			}

		/*     .special 
		    {
			    font-style: italic;
			    font-weight: bold ;
			    color:#bc0000;
			    background:#000;
		    }
		*/

		#leftcolumn { width: 300px; border: 1px solid red; float: left}
		#rightcolumn { width: 300px; border: 1px solid red; float: right}
</style>


    
    
    
 


