@extends('layouts.default')
@section('content')

<?php $name = 'Preimpresos'; ?>
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
      $agencias = DB::select('SELECT * FROM cmb_agencias');        
      $filtros = DB::select('SELECT * FROM cmb_agrupar');
      $agencia = Input::get('agencia');
      $reportrange = Input::get('testdate');               

     $agrupar = Input::get('agrupar');           
  

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
?>


      {{ Form::open(array('url' => 'vPreimpresos')) }}      
      <div class="well">

        <div class="row">
            <div class="col-sm-6 col-lg-3"> 
            <h6>Fechas:</h6>                  
                  <div class="input-prepend input-group">
                     <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                     <input type="text" style="height: 30px" name="testdate" id="testdate" class="form-control" value="{{ $reportrange }}" autofill="false" /> 
                  </div>
              </div>
              <div class="col-sm-6 col-lg-3">       
              <h6>Agencia:</h6>    
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
<!-- Agrupar ....... ...................................................................-->                                                
    <div class="col-md-2">            
      <h6>Agrupar por</h6>
        <select class="selectpicker form-control" name="agrupar" id="agrupar">
          <option value=''></option>                
          <?php
            foreach($filtros as $key => $value2)
            {
              if ($value2->nombre <> 'agencia')
                if ($agrupar == $value2->nombre )
                {   echo "<option value=".$value2->nombre." selected>".$value2->nombre."</option>";    }
                else
                {   echo "<option value=".$value2->nombre.">".$value2->nombre."</option>";             }

            }
          ?>                                                  
          </select>        
      </div> <!-- End of agrupar -->      
      b r
              <div class="col-sm-6 col-lg-3">  
              <h6> .</h6>          
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
      <p>
        <div id='content'>
            <ul id='tabs' class='nav nav-tabs' data-tabs='tabs'>
                <li class='active'><a href='#venta' data-toggle='tab'>Venta</a></li>                
                <li><a href='#logistica' data-toggle='tab'>Logística</a></li>                
            </ul>
             <div id="my-tab-content" class="tab-content">                  
              <div class="tab-pane active" id="venta">                        
                  <p>{{ vPreimpreso::MakeVentaGrid($desde, $hasta); }} </p>  
              </div>
               <div class="tab-pane" id="logistica">                        
                  <p>{{ vPreimpreso::MakeLogisticaGrid($desde, $hasta); }} </p>  
              </div>
                    
          </div>
        </div>
      </p>
      </div> 
   
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