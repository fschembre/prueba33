@extends('layouts.default')
@section('content')

<?php

$reporte = 'rCustom';

        $agencias = DB::select('SELECT * FROM cmb_agencias');        
        $categorias = DB::select('SELECT * FROM cmb_categorias');        
        $productos = DB::select('SELECT * FROM cmb_productos');
        $filtros = DB::select('SELECT * FROM cmb_agrupar');

        $agencia = Input::get('agencia');
        $producto = Input::get('producto');        
        $reportrange = Input::get('reportrange');    
        $agrupar = Input::get('agrupar');           
  
        if ($agrupar == '') 
            $agrupar =  'fecha';

        if ($reportrange <>'') 
            $reportrange =  $reportrange;
        else          
            $reportrange = (date("m/d/Y")." a ".date("m/d/Y"));                                

        $desde = trim(substr($reportrange,  0, 10));        
        $hasta = trim(substr($reportrange, 13,11));
        
        $desde = date('Y-m-d', strtotime($desde));
        $hasta = date('Y-m-d', strtotime($hasta));
  
        $sql = "SELECT id, fecha, producto, agencia, categoria, descripcion, dia, sum(debe) as debe, sum(haber) as haber, sum(debe)-sum(haber) as saldo FROM (SELECT cuentas.id, cuentas.fecha, week(cuentas.fecha, 1) as semana, week(now(), 1) as estasemana, cuentas.producto, cuentas.categoria, cuentas.agencia, dias_de_la_semana.nombre as dia, cuentas.descripcion, cuentas.debe, cuentas.haber FROM cuentas LEFT JOIN dias_de_la_semana ON weekday(cuentas.fecha)= dias_de_la_semana.id where categoria = 'VENTA' or categoria = 'PREMIO' ORDER BY fecha DESC ) A ";
    
        if ($agencia <>'todos')                  
            $sql = $sql."WHERE fecha BETWEEN '".$desde."' AND '".$hasta."' AND  agencia = '".$agencia."' GROUP BY ".$agrupar." ";
        else
          $sql = $sql. "WHERE fecha BETWEEN '".$desde."' AND '".$hasta."' GROUP BY ".$agrupar;




        echo "SQL=".$sql;

        $cuentas = DB::select($sql);  
?> 
<br>

{{ Form::open(array('url' => $reporte)) }}
<div class="well" style="overflow: auto">


  <!-- Date Combobox ....... ...................................................................-->                                                
      <div class="col-md-3">            
         <h6>Fechas</h6>
           <div class="input-prepend input-group">
               <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
               <input type="text" style="width: 200px" name="reportrange" id="reportrange" class="form-control" value="{{ $reportrange }}" /> 
           </div>
      </div>                 
  <!-- Agencia ....... ...................................................................-->                                                
      <div class="col-md-2">            
      <h6>Agencia</h6>
        <select class="selectpicker form-control" name="agencia" id="agencia">
          <option value='todos'>Todas las agencias</option>                
          <?php
            foreach($agencias as $key => $value2)
            {
              if ($agencia == $value2->nombre)
              {   echo "<option value=".$value2->nombre." selected>".$value2->nombre."</option>";    }
              else
              {   echo "<option value=".$value2->nombre.">".$value2->nombre."</option>";             }
            }
          ?>                                                  
          </select>        
      </div> <!-- End of agencia -->

<!-- Agrupar ....... ...................................................................-->                                                
    <div class="col-md-2">            
      <h6>Agrupar por</h6>
        <select class="selectpicker form-control" name="agrupar" id="agrupar">
          <option value=''></option>                
          <?php
            foreach($filtros as $key => $value2)
            {
              if ($agrupar == $value2->nombre)
              {   echo "<option value=".$value2->nombre." selected>".$value2->nombre."</option>";    }
              else
              {   echo "<option value=".$value2->nombre.">".$value2->nombre."</option>";             }

            }
          ?>                                                  
          </select>        
      </div> <!-- End of agencia -->

<!-- Search button..... ...................................................................-->                                        
    <div class="pull-right">
        <div class="col-md-3">
          <h6>.</h6>            
          <button type="submit" value="" class="btn btn-success" type="submit" id="submit"><i class="glyphicon glyphicon-search"></i> Buscar</button>                
        </div>
    </div> <!-- End of Search button -->

</div> <!-- end class well -->
{{ Form::close() }}            


<div>
    <table id="rCustom" class="table table-striped table-bordered cell-border stripe row-border compact" width="100%" cellspacing="0">
        <thead class="display cell-border">
            <tr>
                <td>Fecha</td>                                                                                  
                <td>Agencia</td>                                                                                  
                <td>Producto</td>                                                                                  
                <td>Ventas</td>                                   
                <td>Premios</td>                                                                                                                       
                <td>Saldo</td>                                                                                                                       
            </tr>
        </thead>
         <tbody>
        @foreach ($cuentas as $value)                                                                 
             <tr>
                <td>{{ $value->fecha }}</td>
                <td>{{ $value->agencia }}</td>
                <td>{{ $value->producto }}</td>
                <td align='right'>{{ number_format($value->debe, 0, '.', ',')  }}</td>
                <td align='right'>{{ number_format($value->haber, 0, '.', ',') }}</td>
                <td align='right'>{{ number_format($value->debe-$value->haber, 0, '.', ',') }}</td>
             </tr>
        @endforeach
        </tbody>                                  
        <tfoot id='".$table."' class='table table-striped table-bordered' width='100%' cellspacing='0'>
            <tr>                                              
                <td></td>
                <td></td>
                <td></td>                        
                <td align='right'></td>
                <td align='right'></td>
                <td align='right'></td>
            </tr>
        </tfoot>
    </table>          
</div>
<script type="text/javascript">

               $(document).ready(function() {

//////////////////////////////////////////////////////////////// BEGIN DATATABLE ////////////////////////////////////////////////////////////////
                  $('#rCustom').dataTable
                  ( 
                    {
                        // scrollY: 300,
                        sDom: '"top"i',
                        paging:   true,
                        ordering: true,
                        info:     false,
                        'footerCallback': function ( row, data, start, end, display ) 
                        {
                            var api = this.api(), data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0; };

                            // Total over all pages
                            data = api.column( 3 ).data();
                            debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                            data = api.column( 4 ).data();
                            haber = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;                                        
                            data = api.column( 5 ).data();
                            saldo = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;                                        

                            // Update footer
                            $( api.column( 3 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );
                            $( api.column( 4 ).footer() ).html(haber.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );                        
                            $( api.column( 5 ).footer() ).html(saldo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );                        
                        }
                    } 
                  );
//////////////////////////////////////////////////////////////// END DATATABLE ////////////////////////////////////////////////////////////////
               });
</script>           

@stop