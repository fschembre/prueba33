<?php
class rFecha extends Eloquent {
    
    //protected $table = 'cuentas';       

    public $restful = true;

    public static function MakeResumenGrid($desde, $hasta)
    {        

        //date_default_timezone_set('America/Caracas');

        $desde = rFecha::ConvertDate($desde);
        $hasta = rFecha::ConvertDate($hasta);

        $producto = "Resumen";      
        $agencia = Input::get('agencia');
    

        $sql = "SELECT nombre as dia, fecha, agencia, caja, venta, premio from(select week(now(), 1) as estasemana, 
                week(fecha,1) as semana, weekday(fecha) as dia, fecha, agencia, 
                SUM(IF(categoria = 'CAJA', haber, NULL)) AS caja, 
                SUM(IF(categoria = 'VENTA', debe, NULL)) AS venta, 
                SUM(IF(categoria = 'PREMIO', haber, NULL)) AS premio
                FROM cuentas group by fecha) as A, dias_de_la_semana as B where A.dia = B.id
                AND fecha BETWEEN  '".$desde."' and '".$hasta."'";


        if ($agencia == NULL)
            $sql = $sql." order by fecha asc";
        else
            $sql = $sql." and agencia = 'Maiquetia' order by fecha asc";

     //   echo $sql;


        $cuentas = DB::select($sql);        


echo "
           <table id='resumenReporte' class='table table-striped table-bordered cell-border stripe row-border compact' width='100%' cellspacing='0'>        
                    <thead>
                        <tr>                    
                            <td>Día</td>
                            <td>Fecha</td>                                                                                    
                            <td>Venta</td>                            
                            <td>Premio</td>                                                             
                            <td>Gastos</td>
                            <td>Saldo</td>                                 
                        </tr>
                    </thead>
                    <tbody>";
                    foreach ($cuentas as $value) 
                    {
                 
                        Form::open(array('url' => 'rFecha'));
                        $fecha = date_create($value->fecha);                        
                        $fecha = date_format($fecha, 'd M Y');
    
                    
                                
                                echo "<td><a  data-toggle='modal' data-target='.detalle-modal".$value->fecha."'>                                            
                                ".$value->dia."
                                            </a></td>";
                                 echo "
                                        <div class='modal fade detalle-modal".$value->fecha."'>
                                            <div class='modal-dialog'>
                                              <div class='modal-content'>
                                                <div class='modal-header'>
                                                  <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                  <h4 class='modal-title'>Detalle día: ".$value->dia.", ".$fecha."</h4>
                                                </div>
                                                <div class='modal-body'>




                                                <div class='container-modal'>
                                                    <div class='row-modal'>
                                                        <div class='title-modal'>Descripcion</div>
                                                        <div class='title-modal'>Producto</div>
                                                        <div class='title-modal'>Categoría</div>                                                       
                                                        <div class='title-modal'>Debe</div>        
                                                        <div class='title-modal'>Haber</div>        
                                                        <div class='title-modal'>Saldo</div>                                                                
                                                    </div>";
                                                     $detalle = DB::select("SELECT * FROM cuentas WHERE fecha ='".$value->fecha."' "); 
                                                     $totalDebe= 0;
                                                     $totalHaber=0;
                                                    foreach ($detalle as $value2) 
                                                    {
                                                        $saldo = $value2->debe-$value2->haber;
                                                        $totalDebe= $totalDebe+$value2->debe;
                                                        $totalHaber=$totalHaber+$value2->haber;
                                                echo "
                                                        <div class='row-modal'>
                                                            <div class='column-modal'>".$value2->descripcion."</div>
                                                            <div class='column-modal'>".$value2->producto."</div>        
                                                            <div class='column-modal'>".$value2->categoria."</div>                                                                            
                                                            <div class='column-modal' align='right'>".number_format($value2->debe, 0, '.', ',')."</div>        
                                                            <div class='column-modal' align='right'>".number_format($value2->haber, 0, '.', ',')."</div>        
                                                            <div class='column-modal' align='right'>".number_format($saldo, 0, '.', ',')."</div>        
                                                        </div>
                                                    ";                                                    
                                                    }
echo "                                                  <div class='row-modal'>
                                                           <div class='results-modal'></div>        
                                                            <div class='results-modal'></div>        
                                                            <div class='results-modal'></div>        
                                                            <div class='results-modal' align='right'>".number_format($totalDebe, 0, '.', ',')."</div>        
                                                            <div class='results-modal' align='right'>".number_format($totalHaber, 0, '.', ',')."</div>        
                                                            <div class='results-modal' align='right'>".number_format(($totalDebe-$totalHaber), 0, '.', ',')."</div>        
                                                        </div>";
echo"                                              </div>
                       

                                                </div>
                                                <div class='modal-footer'>
                                                  
                                                  <button type='button' class='btn btn-primary' data-dismiss='modal'>Cerrar</button>   
                                                </div>
                                              </div>
                                            </div>
                                        </div>";
                        Form::close();
                        

                        $fecha = date_create($value->fecha);
                        $fecha = date_format($fecha, 'd/m/Y');
                        
                        echo "<td>".$fecha."</td>";
                        
                        $saldo = $value->venta - $value->caja - $value->premio;
                            
                        echo "<td align='right'>".number_format($value->venta, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->premio, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->caja, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($saldo, 0, '.', ',')."</td>";
                        
                        echo "</tr>";
                    }
        echo        "</tbody>                    
                    <tfoot id='resumenReporte' class='display cell-border' width='100%' cellspacing='0'>
                        <tr class='success'> 
                            <td></td>
                            <td align='center'></td>
                            <td align='right'></td>
                            <td align='right'></td>
                            <td align='right'></td>                                                                  
                            <td align='right'></td>                                                                                              
                        </tr>
                    </tfoot>
                </table>";
    } //End of function


    public static function MakeCajaGrid($desde, $hasta)
    {        
     
        $agencia = Input::get('agencia');     

        $desde = rFecha::ConvertDate($desde);
        $hasta = rFecha::ConvertDate($hasta);
      
        $sql = "SELECT * FROM
                (SELECT weekday(fecha) as dia, agencia, fecha, descripcion, debe, haber 
                FROM cuentas
                WHERE producto = 'caja' ) AS A, dias_de_la_semana AS B
                WHERE A.dia = B.id AND fecha between '".$desde."' and '".$hasta."'";
       
        if ($agencia <> NULL)
            $sql = $sql." and agencia = '".$agencia."'";
       
       // echo $sql;

        $cuentas = DB::select($sql);        
        
        echo " <style type='text/css'> .dataTables_filter { display: none; } </style> ";
        echo "<script type='text/javascript' language='javascript' class='init'>
                        
                            $(document).ready(function() {
                                $('#cajaReporte').dataTable( {
                                    autoWidth: true,
                                    paging:   false,
                                    ordering: false,
                                    info:     false,
                                    'footerCallback': function ( row, data, start, end, display ) {
                                        var api = this.api(), data;
                             
                                    // Remove the formatting to get integer data for summation
                                        var intVal = function ( i ) {
                                            return typeof i === 'string' ?
                                                i.replace(/[\$,]/g, '')*1 :
                                                typeof i === 'number' ?
                                                    i : 0; };
                             
                                    // Total over all pages
                                        
                                        data = api.column( 3 ).data();
                                        haber = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                        data = api.column( 4 ).data();
                                        saldo = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;                                                            
                                        data = api.column( 5 ).data();
                                        saldo = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;     
                                    // Update footer                                        
                                        $( api.column( 3 ).footer() ).html(haber.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, \"$1,\") );
                                        $( api.column( 4 ).footer() ).html(saldo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, \"$1,\") );
                                        $( api.column( 5 ).footer() ).html(saldo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, \"$1,\") );
                                    }
                                } );
                            } );

                </script>";
        
        echo   "<table id='cajaReporte' class='table table-striped table-bordered cell-border stripe row-border compact' width='100%' cellspacing='0'>        
                    <thead>
                        <tr>                    
                            <td>Día</td>
                            <td>Fecha</td>                            
                            <td>Descripcion</td>                                   
                            <td>Debe</td>                                                                                           
                            <td>Haber</td>     
                            <td>Saldo</td>     
                        </tr>
                    </thead>
                    <tbody>";
                     foreach ($cuentas as $value) 
                    {
                        echo "<tr>";
                            echo "<td>".$value->nombre."</td>";
                            $fecha = date_create($value->fecha);
                            $fecha = date_format($fecha, 'd/m/Y');
                            echo "<td>".$fecha."</td>";
                            echo "<td>".$value->descripcion."</td>";
                            echo "<td align='right'>".number_format($value->debe, 0, '.', ',')."</td>";
                            echo "<td align='right'>".number_format($value->haber, 0, '.', ',')."</td>";
                            echo "<td align='right'>".number_format($value->debe-$value->haber, 0, '.', ',')."</td>";                            
                            echo "</tr>";
                    }
        echo        "</tbody>";                    
        echo            "<tfoot id='cajaReporte' class='display cell-border' width='100%' cellspacing='0'>
                        <tr class='success'>
                            <td></td>
                            <td></td>                           
                            <td></td>                           
                            <td align='right'></td>
                            <td align='right'></td>                           
                            <td align='right'></td>
                        </tr>
                    </tfoot>
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


    public static function MakeDetalle($fecha)
    {


    }
} //End of class
