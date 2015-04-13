<?php
class vLoteria extends Eloquent {
    
    protected $table = 'vloteria';       

    public $restful = true;

 public static function MakeGrid()
    {                    
        $sql="SELECT * FROM vloteria order by id desc";
        
        $data = DB::select($sql);                       
 		 		               
		echo "  <style type='text/css'> .dataTables_filter { display: none; } </style> 
			    <script type='text/javascript' language='javascript' class='init'>
		    
		        $(document).ready(function() {
		            $('#one').dataTable( {
		                sDom: '\"top\"i',
		                autoWidth: true,
		                paging:   true,
		                ordering: false,
		                info:     false
		                
		            } );
		        } );
				</script>
				<table id='one' class='table table-striped table-bordered cell-border stripe row-border compact' width='100%' cellspacing='0'>
			        <thead class='display cell-border'>
			            <tr>
			                <td>id</td>
			                <td>Fecha</td>
			                <td>Agencia</td>
			                <td>Venta</td>
			                <td>Premio</td>
			                <td></td>
			                <td></td>
			            </tr>
			        </thead>
			        <tbody>";
			       foreach ($data as $value) 
			       {                                                            
			        echo "
			             <tr>                                         
			                <td><font color=black>".$value->id."</font></td>
			                <td><font color=black>".$value->fecha."</font></td>
			                <td>".$value->agencia."</td>
			                <td align='right'>".number_format($value->venta, 0, '.', ',')."</td>
			                <td align='right'>". number_format($value->premio, 0, '.', ',')."</td>                  
			                <td width='1%'><a class='alert' href=#><button type='button' class='btn btn-warning btn-circle'><i class='glyphicon glyphicon-edit'></i></button></a></td> 
							<td width='1%'><a class='alert' href=#><button type='button' class='btn btn-danger btn-circle'><i class='glyphicon glyphicon-remove'></i></button></a></td> 
			            </tr>";
			        }
					echo "        
			        </tbody>                                          
			    </table>";
                
    } //End of function

    public static function ConvertDate($fecha)
    {
        $dfecha =  trim(substr($fecha, 0, 2));    
        $mfecha =  trim(substr($fecha, 3, 2));    
        $yfecha =  trim(substr($fecha, 6, 4));    
        $fecha = $yfecha."-".$mfecha."-".$dfecha;  
        return $fecha;
    }
   public static function DateConvert($fecha)
    {
        $fecha = date_create($fecha);
        $fecha = date_format($fecha, 'd M Y');
        return $fecha;
    }
                 
   public static function Editar($id)
    {      

	echo"	<script>
					$(document).on('click', '.alert', function(e) 
					{
					  form= '<form id='infos' action=''>\
					          Fecha:<input type='text' name='fecha' placeholder='wepa'></input><br/>\
					          Agencia:<input type='text' name='agencia'></input><br/>\
					          Venta:<input type='text' name='venta'></input><br/>\
					          Premio:<input type='text' name='premio'></input>\
					          </form>';
					     bootbox.confirm(form, function(result) 
					                        {
					                            if(result)
					                                $('#infos').submit();
					                        });
									});
			</script>";

	}

} //End of class

