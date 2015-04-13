<?php
class vFecha extends Eloquent {
    
    //protected $table = 'cuentas';       

    public $restful = true;



    public static function MakeGrid($producto, $desde, $hasta)
    {        
     
        $agencia = Input::get('agencia');     

        $desde = vFecha::ConvertDate($desde);
        $hasta = vFecha::ConvertDate($hasta);
      
        $sql = "select nombre, fecha, agencia, sum(venta) as venta, sum(premio) as premio, sum(venta)-sum(ifnull(premio,0)) as saldo 
                from ( select fecha, weekday(fecha) as dia, agencia, sum(venta) as venta, sum(premio) as premio from ".$producto." group by agencia, fecha 
                ) as A, dias_de_la_semana as B where A.dia = B.id 
                and fecha between '".$desde."' and '".$hasta."'";                
               if ($agencia <> NULL)
                    $sql = $sql." and agencia = '".$agencia."'";
                $sql = $sql." group by fecha order by fecha asc";
       
  //   echo $sql;

        $cuentas = DB::select($sql);        
        
        echo " <style type='text/css'> .dataTables_filter { display: none; } </style> ";
        echo "<script type='text/javascript' language='javascript' class='init'>
                        
                            $(document).ready(function() {
                                $('#".$producto."').dataTable( {
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
                                        data = api.column( 2 ).data();
                                        debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                        data = api.column( 3 ).data();
                                        haber = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                        data = api.column( 4 ).data();
                                        saldo = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;                                                            
                             
                                    // Update footer
                                        $( api.column( 2 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, \"$1,\") );
                                        $( api.column( 3 ).footer() ).html(haber.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, \"$1,\") );
                                        $( api.column( 4 ).footer() ).html(saldo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, \"$1,\") );
                                    }
                                } );
                            } );

                </script>";
        
        echo   "<table id='".$producto."' class='table table-striped table-bordered cell-border stripe row-border compact' width='100%' cellspacing='0'>        
                    <thead>
                        <tr class = 'titles'>                    
                            <td>Día</td>
                            <td>Fecha</td>                            
                            <td>Venta</td>                                   
                            <td>Premio</td>                                                                                           
                            <td>Saldo</td>     
                            <td>% Premiación</td>     
                        </tr>
                    </thead>
                    <tbody>";
                     foreach ($cuentas as $value) 
                    {
                        echo "<tr>";
                            echo "<td>".$value->nombre."</td>";
                            echo "<td align='center'>".vFecha::DateConvert($value->fecha)."</font></td>";
                            if ( $value->venta <> 0 )
                                $porcentaje = ($value->premio/$value->venta)*100;
                            else
                                $porcentaje = 0;
                            echo "<td align='right'>".number_format($value->venta, 0, '.', ',')."</td>";
                            echo "<td align='right'>".number_format($value->premio, 0, '.', ',')."</td>";
                            echo "<td align='right'>".number_format($value->venta-$value->premio, 0, '.', ',')."</td>";
                            echo "<td align='right'>".number_format($porcentaje, 2, '.', ',')."%</td>";
                            echo "</tr>";
                    }
        echo        "</tbody>";                    
        echo            "<tfoot id= ".$producto." class='display cell-border' width='100%' cellspacing='0'>
                        <tr class='success2'>
                            <td></td>
                            <td></td>                           
                            <td align='right'></td>
                            <td align='right'></td>
                            <td align='right'></td>
                            <td align='right'></td>
                        </tr>
                    </tfoot>

                </table>";
                
    } //End of function

 public static function MakeResumenGrid($agencia, $desde, $hasta)
    {             
        $agencia = Input::get('agencia');     
        $producto = "Resumen";

        $desde = vFecha::ConvertDate($desde);
        $hasta = vFecha::ConvertDate($hasta);
      
        $sql="SELECT nombre, fecha, vloteria, vparley, vpreimpreso, vcopia, ploteria, pparley, ppreimpreso, pcopia, 
                ifnull(vloteria,0)+ifnull(vparley,0)+ifnull(vpreimpreso*0.15,0)+ifnull(vcopia,0)-ifnull(ploteria,0)-ifnull(pparley,0)-ifnull(ppreimpreso,0)-ifnull(pcopia,0) as saldo 
                FROM dias_de_la_semana AS A INNER JOIN (        
                SELECT weekday(fecha) as dia, fecha, agencia, 
                sum(vloteria) as vloteria, sum(vparley) as vparley, sum(vpreimpreso) as vpreimpreso, sum(vcopia) as vcopia, 
                sum(ploteria) as ploteria, sum(pparley) as pparley, sum(ppreimpreso) as ppreimpreso, sum(pcopia) as pcopia, 
                vloteria+vparley+vpreimpreso+vcopia-ploteria-pparley-ppreimpreso-pcopia as saldo FROM (
                SELECT fecha, agencia, MAX(IF(producto = 'lot', venta, NULL)) AS vLoteria, 
                MAX(IF(producto = 'par', venta, NULL)) AS vParley, 
                MAX(IF(producto = 'pre', venta, NULL)) AS vPreimpreso, 
                MAX(IF(producto = 'cop', venta, NULL)) AS vCopia, 
                MAX(IF(producto = 'caj', venta, NULL)) AS vCaja, 
                MAX(IF(producto = 'lot', premio, NULL)) AS pLoteria, 
                MAX(IF(producto = 'par', premio, NULL)) AS pParley, 
                MAX(IF(producto = 'pre', premio, NULL)) AS pPreimpreso, 
                MAX(IF(producto = 'cop', premio, NULL)) AS pCopia, 
                MAX(IF(producto = 'caj', premio, NULL)) AS pCaja 
                FROM (
                SELECT * FROM( 
                SELECT 'lot' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vloteria group by fecha, agencia union 
                SELECT 'par' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vparley group by fecha, agencia union 
                SELECT 'pre' as producto, agencia, fecha, sum(ifnull(venta,0)) as venta, ifnull(premio,0) as premio from vpreimpreso group by fecha, agencia union 
                SELECT 'cop' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcopia group by fecha, agencia union 
                SELECT 'caj' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcaja group by fecha, agencia 
                ) as a where fecha between '".$desde."' and '".$hasta."'
                ) as y  group by agencia, producto, fecha order by fecha) as z ";
                if ($agencia <> "")        
                $sql = $sql." where agencia = '".$agencia."'";     
                $sql = $sql." group by fecha ) as B ON A.id = B.dia order by fecha asc";
                            
      // echo $sql;
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
                                        for (x=2; x<=9; x++) 
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
                            <td>Venta Loteria</td>                                   
                            <td>Venta Parley</td>
                            <td>Venta Preimpresos</td>
                            <td>Venta Copias</td>
                            <td>Premio Loteria</td>                                 
                            <td>Premio Parley</td>    
                            <td>Premio Preimpreso</td>                                
                            <td>Saldo</td>                                 
                        </tr>
                    </thead>
                    <tbody>";
                    foreach ($cuentas as $value) 
                    {                                                                
                        echo "<td>".$value->nombre."</td>";                        
                        echo "<td align='center'><font color=black>".vFecha::DateConvert($value->fecha)."</font></td>";
                        echo "<td align='right'>".number_format($value->vloteria, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->vparley, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->vpreimpreso, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->vcopia, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->ploteria, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->pparley, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->ppreimpreso, 0, '.', ',')."</td>";
                        echo "<td align='right'>".number_format($value->saldo, 0, '.', ',')."</td>";                        
                        echo "</tr>";
                    }
        echo        "</tbody>                    
                    <tfoot id='resumen1' class='display cell-border' width='100%' cellspacing='0'>
                        <tr class='success2'> 
                            <td></td>
                            <td></td>
                            <td align='right'></td>
                            <td align='right'></td>
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
        $fecha = date_format($fecha, 'd M y');
        return "<div align='center'><font color=black>".$fecha."</font></div>";
    }
                 
} //End of class

