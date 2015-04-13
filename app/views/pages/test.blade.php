<!DOCTYPE html>
<html>
@include('includes.head')
<body>
 
    <p>Content here. <a class="alert" href=#>Alert!</a></p>
 
    <script>
        $(document).on("click", ".alert", function(e) 
        {
             bootbox.confirm("<form id='infos' action=''>\
                                Fecha:<input type='text' name='fecha'></input><br/>\
                                Agencia:<input type='text' name='agencia'></input><br/>\
                                Venta:<input type='text' name='venta'></input><br/>\
                                Premio:<input type='text' name='premio'></input>\
                                </form>", function(result) 
                                {
                                    if(result)
                                        $('#infos').submit();
                                });
        });
    </script>


</body>
</html>