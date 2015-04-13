<script>
$( document ).ready(function() {
  var lineColor = ['#1caf9a','#357ebd', '#8C8C8C', '#F0AD4E'];
  var day_data = [];
 
  var myURL = location.href;
  var myDir = myURL.substring( 0, myURL.lastIndexOf( "/" ) + 1);
  myDir = myDir.concat('SalesArea');

  $.getJSON( myDir, function(day_data) 
  {
      
    Morris.Area({
      element: 'SalesArea',
      data: day_data,
      xkey: 'period',
      ykeys: ['a', 'b', 'c', 'd'],
      labels: ['A', 'B','C', 'D'],
      lineColors: lineColor,
      hoverCallback: function(index, options, content) { 
         var displayDate = "<b>"+changeDateFormat(day_data[index]['period'])+"</b><br>";
         var param1 = "<font color='"+lineColor[0]+"'>Venta Lotería: "+day_data[index]['a']+"</font><br>";
         var param2 = "<font color='"+lineColor[1]+"'>Venta Parley:  "+day_data[index]['b']+"</font><br>";
         var param3 = "<font color='"+lineColor[2]+"'>Venta Preimpresos: "+day_data[index]['c']+"</font><br>";
         var param4 = "<font color='"+lineColor[3]+"'>Venta Copias: "+day_data[index]['d']+"</font><br>";
         return displayDate+param1+param2+param3+param4;
      },
      xLabelFormat : function (x) {
       return changeDateFormat(x);
      }
    });
  });

});   
</script>

<script>
$( document ).ready(function() {
  var lineColor = ['#1caf9a','#357ebd', '#8C8C8C', '#F0AD4E'];
  var day_data = [];
 
  var myURL = location.href;
  var myDir = myURL.substring( 0, myURL.lastIndexOf( "/" ) + 1);
  myDir = myDir.concat('Donut');

  $.getJSON( myDir, function(day_data) 
  {      
  Morris.Donut({
    element: 'donut',
    data: day_data,
    backgroundColor: '#ccc',
    labelColor: '#060',
    colors: [
    '#F0AD4E',
    '#1caf9a',
    '#357ebd',
    '#8C8C8C'
    ],
    formatter: function (x) { return x + "%"}
    }).on('click', function(i, row){
    console.log(i, row);
    });    
  });

});   
</script>


<script>
$( document ).ready(function() {
  var lineColor = ['#1caf9a','#357ebd', '#8C8C8C', '#F0AD4E'];
  var day_data = [];
 
  var myURL = location.href;
  var myDir = myURL.substring( 0, myURL.lastIndexOf( "/" ) + 1);
  myDir = myDir.concat('SalesLine');

  $.getJSON( myDir, function(day_data) 
  {
      
            Morris.Line(
            {
              element: 'SalesLine',
              data: day_data,
              xkey: 'y',
              ykeys: ['a', 'b'],
              labels: ['A', 'B']
            });
  });

});   
</script>


<script>
$( document ).ready(function() {
  var lineColor = ['#7BB661', '#1caf9a', '#8C8C8C', '#F0AD4E'];
  var day_data = [];
 
  var myURL = location.href;
  var myDir = myURL.substring( 0, myURL.lastIndexOf( "/" ) + 1);
  myDir = myDir.concat('Saldo');

  $.getJSON( myDir, function(day_data) 
  {
      
            Morris.Line(
            {
              element: 'Saldo',
              data: day_data,
              xkey: 'period',
              ykeys: ['a'],
              labels: ['Bs']
            });
  });

});   
</script>





<script>
  function changeDateFormat(mydate)
  {
    var dateDMY = new Date(mydate);
    var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ]; 
    var date =  dateDMY.getDate();
    var month = monthNames[dateDMY.getMonth()];
    var year = dateDMY.getFullYear();
    var mydate = "";
    var seperator = "-";
    mydate = mydate.concat(date,seperator,month,seperator,year);
    return mydate;
  }
</script>
