<?php
class vPreimpreso extends Eloquent {
    
    //protected $table = 'cuentas';       

    public $restful = true;



    public static function MakeLogisticaGrid($desde, $hasta)
    {        
     
        $agencia = Input::get('agencia');     
        $agrupar = Input::get('agrupar'); 

        $desde = vFecha::ConvertDate($desde);
        $hasta = vFecha::ConvertDate($hasta);
      
        $sql = "SELECT * FROM ( SELECT weekday(fecha) as dia, fecha, A.sorteo, producto, valor, cant_recibida, fecha_devuelta, cant_devuelta, cant_vendida, 
                valor*cant_vendida as total, fecha_pago FROM cant_preimpresos as A LEFT JOIN cmb_preimpresos as B ON A.sorteo = B.sorteo ) AS C 
                LEFT JOIN dias_de_la_semana as D on C.dia = D.id WHERE                  
                fecha BETWEEN '".$desde."' and '".$hasta."' " ;
                if ($agencia <> "")        
                    $sql = $sql." and agencia = '".$agencia."'"; 
               
                if ($agrupar <> "")        
                   $sql = $sql." group by ".$agrupar." "; 
               
                $sql = $sql."ORDER BY fecha DESC";

       
 //  echo $sql;

        $cuentas = DB::select($sql);        
        
        echo " <style type='text/css'> .dataTables_filter { display: none; } </style> ";
        echo "<script type='text/javascript' language='javascript' class='init'>
                        
                            $(document).ready(function() {
                                $('#Logistica".$agrupar."').dataTable( {
                                    sDom: '\"top\"i',
                                    autoWidth: true,
                                    paging:   true,
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
                                    for (x=5; x<=9; x++) 
                                    {
                                        data = api.column( x ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                            $( api.column( x ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, \"$1,\") );
                                    }                                                                                                       
                                    }
                                } );
                            } );

                </script>";
        
        echo   "<table id='Logistica".$agrupar."' class='table table-striped table-bordered cell-border stripe row-border compact' width='100%' cellspacing='0'>        
                    <thead>
                        <tr class = 'titles'>                    
                            <td>Día</td>
                            <td>Fecha</td>
                            <td>Fecha Devuelta</td>
                            <td>Fecha de Pago</td>
                            <td>Producto</td>                                                               
                            <td>Cantidad Recibida</td>
                            <td>Cantidad Vendida</td>
                            <td>Cantidad Devuelta</td>                            
                            <td>Total Vendido</td>
                            <td>Total 15%</td>
                            
                        </tr>
                    </thead>
                    <tbody>";
                     foreach ($cuentas as $value) 
                    {
                        echo "<tr>";
                            echo "<td>".$value->nombre."</td>";
                            echo "<td align='center'><font color=black>".vPreimpreso::DateConvert($value->fecha)."</font></td>";                                            
                            echo "<td align='center'><font color=black>".vPreimpreso::DateConvert($value->fecha_devuelta)."</font></td>";                                            
                            echo "<td align='center'><font color=black>".vPreimpreso::DateConvert($value->fecha_pago)."</font></td>";                                
                            echo "<td>".$value->producto."</td>";                            
                            echo "<td align='right'>".number_format($value->cant_recibida, 0, '.', ',')."</td>";
                            echo "<td align='right'>".number_format($value->cant_vendida, 0, '.', ',')."</td>";                            
                            echo "<td align='right'>".number_format($value->cant_devuelta, 0, '.', ',')."</td>";                            
                            echo "<td align='right'>".number_format($value->total, 0, '.', ',')."</td>";                            
                            echo "<td align='right'>".number_format($value->total*(0.15), 0, '.', ',')."</td>";                                                        
                            echo "</tr>";
                    }
        echo        "</tbody>";                    
        echo            "<tfoot id='Logistica".$agrupar."' class='display cell-border' width='100%' cellspacing='0'>
                        <tr class='success2'>
                            <td></td>                                                    
                            <td></td> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align='right'></td>
                            <td align='right'></td>
                            <td align='right'></td>
                            <td align='right'></td>
                            <td align='right'></td>
                        </tr>
                    </tfoot>

                </table>";
                
    } //End of function

 public static function MakeVentaGrid($desde, $hasta)
    {        
     
      

        $agrupar = Input::get('agrupar');             
        $agencia = Input::get('agencia');             

        $desde = vPreimpreso::ConvertDate($desde);
        $hasta = vPreimpreso::ConvertDate($hasta);
      
        $sql="  SELECT D.nombre, producto, fecha, agencia, sum(cant) as cant, precio, sum(cant*precio) as venta, cant*precio*(0.15) as quince, premio, sorteo 
                FROM ( SELECT  nombre as producto, weekday(fecha) as dia, fecha, agencia, venta, nombre, cant, A.precio as precio, premio, A.sorteo as sorteo 
                FROM vpreimpreso as A LEFT JOIN cmb_preimpresos as B ON A.sorteo = B.sorteo ) AS C LEFT JOIN dias_de_la_semana as D on C.dia = D.id 
                WHERE fecha BETWEEN '".$desde."' and '".$hasta."' " ;
           //     if ($agencia <> "")        
           //         $sql = $sql." and agencia = '".$agencia."'"; 
               
                if ($agrupar <> "")        
                   $sql = $sql." group by ".$agrupar." "; 
               
                $sql = $sql."ORDER BY fecha DESC";


                            
   echo $sql;

        $cuentas = DB::select($sql);
        
        echo "<style type='text/css'> .dataTables_filter { display: none; } </style> ";
        echo "<script type='text/javascript' language='javascript' class='init'>
                        
                            $(document).ready(function() {
                                $('#resumen1').dataTable( {
                                    sDom: '\"top\"i',
                               
                                    autoWidth: true,
                                    paging:   true,
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
                                        for (x=6; x<=8; x++) 
                                        {
                                            data = api.column( x ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                                $( api.column( x ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, \"$1,\") );
                                        }                                                                            
                                    }
                                } );
                            } );

                </script>";
        
      echo   "<table id='resumen1' class='table table-striped table-bordered cell-border stripe row-border compact' width='100%' cellspacing='0'>        
                    <thead>
                        <tr>                                            
                            <td>Día</td>
                            <td>Fecha</td>                            
                             <td>Producto</td>                                   
                            <td>Agencia</td>                                   
                            <td>Sorteo</td>                                                    
                            <td>Cantidad</td>
                            <td>Precio</td>                            
                            <td>Venta</td>
                            <td>Premio</td>
                            <td>15%</td>
                            
                        </tr>
                    </thead>
                    <tbody>";
                    foreach ($cuentas as $value) 
                    {
                 
                                                
                        echo "<td>".$value->nombre."</td>";                                                
                        echo "<td align='center'><font color=black>".vPreimpreso::DateConvert($value->fecha)."</font></td>";    
                        echo "<td>".$value->producto."</td>";
                        echo "<td>".$value->agencia."</td>";
                        echo "<td>".$value->sorteo."</td>";
                        echo "<td align='right'>".number_format($value->cant, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->precio, 0, '.', ',')."</td>";                        
                        echo "<td align='right'>".number_format($value->venta, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->premio, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->quince, 0, '.', ',')."</td>";
                        
                        echo "</tr>";
                    }
        echo        "</tbody>                    
                    <tfoot id='resumen1' class='display cell-border' width='100%' cellspacing='0'>
                        <tr class='success2'> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align='right'></td>
                            <td align='right'></td>
                            <td align='right'></td>                                      
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


    public static function DateConvert($fecha)
    {
       $fecha = date_create($fecha);
       $fecha = date_format($fecha, 'd M Y');
       return $fecha;
    }
                        


} //End of class

