<div id="copyright text-right"></div>

<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>		
																   	
	<!-- Dashboard 
	<script src="assets/dashboard/js/bootstrap.min.js"></script>


Morris Charts JavaScript 		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="http://cdn.oesmith.co.uk/morris-0.5.1.min.js"></script>

 Restfillizer ??? 
	<script src="{{ asset('js/restfulizer.js') }}"></script> 

          
-->
<script language="JavaScript" type="text/javascript">
$("td").each(function() 
{
  var text = $(this).text();
  
	  if (/[+-]?\d+(\.\d+)?/.test(text)) 
	  {
	    var num = parseFloat(text);

	    {	    	
		    if (num < 0) 
		    {
		      $(this).addClass("negative");
		    } else if (num > 0) 
		    {
		      $(this).addClass("positive");
		    }
		}
	  }
});
</script>