@extends('layouts.default')
@section('content')
<?php $name = 'Gastos'; ?>
  <!-- Page Heading -->
  <div class="row">
      <div class="col-lg-12">
         
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="home">Principal</a>
              </li>
              <li class="active">
                  <i class="fa fa-edit"></i> {{ $name }}
              </li>
          </ol>
      </div>
  </div>
  <!-- /.row -->
<?php

      $reporte = 'vProductos';

      $agencias = DB::select('SELECT * FROM cmb_agencias');        
      $categorias = DB::select('SELECT distinct categoria as nombre FROM vcaja');        

      $agencia = Input::get('agencia');
      $categoria = Input::get('categoria');

      $reportrange = Input::get('testdate');               

      if ($reportrange <>'')       
      {
        $reportrange =  Input::get('testdate');       
        $desde = trim(substr($reportrange,  0, 10));              
        $hasta =  trim(substr($reportrange, 12));        
      }
        
      else                    
         {
              if(date('D')!='Mon')  
              {    
                 //take the last monday
                  $desde = date('d/m/Y',strtotime('last Monday'));    
                  $hasta = date('d/m/Y',strtotime('next Sunday'));
              }
              else    
              {
                  $desde = date('d/m/Y');   
                  $hasta = date('d/m/Y',strtotime('next Sunday'));
              }
              $reportrange = $desde." a ".$hasta;
         }  

        $desde = vFecha::ConvertDate($desde);
        $hasta = vFecha::ConvertDate($hasta);

        $sql = "select nombre, fecha, agencia, descripcion, venta as aporte, premio as gasto 
                from vcaja left join  dias_de_la_semana on weekday(vcaja.fecha)= dias_de_la_semana.id
                where fecha between '".$desde."' AND '".$hasta."'";



        if ($agencia <>'')                  
          $sql = $sql." AND  agencia = '".$agencia."'";
        if ($categoria <>'')                  
          $sql = $sql." AND  categoria = '".$categoria."'";
        $sql = $sql." order by fecha DESC";
      //  echo $sql;

    //    echo $sql; 


        $cuentas = DB::select($sql);  
?> 
<br>

{{ Form::open(array('url' => 'rCostos')) }}      
<div class="well">
  <div class="row">
        <div class="col-sm-6 col-lg-3">                   
            <div class="input-prepend input-group">
               <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
               <input type="text" style="width: 200px" name="testdate" id="testdate" class="form-control" value="{{ $reportrange }}" /> 
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">            
          <select class="selectpicker form-control" name="agencia" id="agencia">
          <option value=''>Todas las agencias</option>                
          <?php
              foreach($agencias as $key => $value2)  {
                  if ($agencia == $value2->nombre)
                     echo "<option value=".$value2->nombre." selected>".$value2->nombre."</option>";   
                  else  
                     echo "<option value=".$value2->nombre.">".$value2->nombre."</option>";                      
              }
          ?>                                                  
          </select>        
        </div>
        <div class="col-sm-6 col-lg-3">            
          <select class="selectpicker form-control" name="categoria" id="categoria">
          <option value=''>Todas las categorías</option>                
          <?php
              foreach($categorias as $key => $value2)  {
                  if ($categoria == $value2->nombre)
                     echo "<option value=".$value2->nombre." selected>".$value2->nombre."</option>";   
                  else  
                     echo "<option value=".$value2->nombre.">".$value2->nombre."</option>";                      
              }
          ?>                                                  
          </select>        
        </div>



        <div class="col-sm-6 col-lg-3">            
          <div class="form-group">
            <button type="submit" value="" class="btn btn-primary" type="submit" id="submit"><i class="glyphicon glyphicon-search"></i> Buscar</button>                
        </div>  
        <div class="col-sm-6 col-lg-3">
        <!-- Insert content for fourth column here -->
        </div>
      </div>  
  </div> <!-- End of row class -->
</div>    <!-- End of well class   -->   
{{ Form::close() }}           

<div>
    <table id="vProductos" class="table table-striped table-bordered cell-border stripe row-border compact" width="100%" cellspacing="0">
        <thead class="display cell-border">
            <tr>
                <td>Día</td>
                <td>Fecha</td>
                <td>Agencia</td>
                <td>Descripción</td>
                <td>Retiro</td>
                <td>Gastos</td>
            </tr>
        </thead>
         <tbody>
        @foreach ($cuentas as $value)                                                                 
             <tr>      
                <td>{{ $value->nombre }}</td>                                   
                <td>{{ vFecha::DateConvert($value->fecha) }}</td>
                <td>{{ $value->agencia }}</td>
                <td>{{ $value->descripcion }}</td>
                <td align='right'>{{ number_format($value->aporte, 0, '.', ',')  }}</td>
                <td align='right'>{{ number_format($value->gasto, 0, '.', ',') }}</td>                
             </tr>
        @endforeach
        </tbody>                                  
        <tfoot id='".$table."' class='table table-striped table-bordered' width='100%' cellspacing='0'>
            <tr class='success2'>    
                <td></td>                                           
                <td></td>              
                <td></td>                        
                <td></td>                        
                <td align='right'></td>              
                <td align='right'></td>
            </tr>
        </tfoot>
    </table>          
</div>
<script type="text/javascript">

               $(document).ready(function() {
//////////////////////////////////////////////////////////////// BEGIN DATATABLE ////////////////////////////////////////////////////////////////
                  $('#vProductos').dataTable
                  ( 
                    {
                        // scrollY: 300,
                        sDom: 'f"top"i',
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
                            data = api.column( 4 ).data();
                            haber = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;                                        
                            data = api.column( 5 ).data();
                            saldo = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;                                        

                            // Update footer                            
                            $( api.column( 4 ).footer() ).html(haber.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );                        
                            $( api.column( 5 ).footer() ).html(saldo.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );                        
                        }
                    } 
                  );
//////////////////////////////////////////////////////////////// END DATATABLE ////////////////////////////////////////////////////////////////
               });
</script>           
<script type="text/javascript">
 $(document).ready(function() {                                              
    var cb = function(start, end, label) 
    {                                       
      $('#testdate span').html(start.format(' D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));                   
    }
    var optionSet1 = 
    {
      format: 'DD/MM/YYYY',
      startDate: moment().subtract(29, 'days'),
      endDate: moment(),                    
      ranges: {
         'Semana Actual': [moment().startOf('week').add(1, 'days'), moment().endOf('week').add(1, 'days')],
         'Semana Pasada': [moment().subtract(1, 'week').startOf('week').add(1, 'days'), moment().subtract(1, 'week').endOf('week').add(1, 'days')],
         'Semana Antepasada': [moment().subtract(2, 'week').startOf('week').add(1, 'days'), moment().subtract(2, 'week').startOf('week').add(7, 'days')],
         'Este Mes': [moment().startOf('month'), moment().endOf('month')],
         'Ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
  //    opens: 'left',
      showDropdowns: true,
      showWeekNumbers: true,
      timePicker: false,
      timePickerIncrement: 1,
      timePicker12Hour: true,
      buttonClasses: ['btn btn-success'],
      applyClass: 'btn-xs btn-primary',
      cancelClass: 'btn-xs',                    
      separator: ' a ',
      locale: {
          applyLabel: 'Aceptar',
          cancelLabel: 'Borrar',
          fromLabel: 'Desde',
          toLabel: 'Hasta',
          customRangeLabel: 'Customizar',
          daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
          monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
          firstDay: 1
      }
    };                 
    $('#testdate').daterangepicker(optionSet1, cb);
    $('#testdate').on('apply.daterangepicker', function(ev, picker) { 
      console.log("apply event fired, start/end dates are " 
        + picker.startDate.format('D MMMM YYYY') 
        + " to " 
        + picker.endDate.format('D MMMM YYYY')
      ); 
    });
 });
</script>   
@stop