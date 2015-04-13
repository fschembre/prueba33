<?php
        $reporte = 'cuentas';

        $agencias = DB::select('SELECT * FROM cmb_agencias');        
        $categorias = DB::select('SELECT * FROM cmb_categorias');        
        $productos = DB::select('SELECT * FROM cmb_productos');
        $preimpresos = DB::select('SELECT * FROM cmb_preimpresos');  

        $agencia = Input::get('agencia');
        $producto = Input::get('producto');        
?>


    

<!-- .................................................END MODAL VIEW .................................................................................-->

<!-- .................................................BEGIN MODAL VIEW .................................................................................-->

<!-- ADD DAY MODAL WINDOW ...................................................................-->

<div class="modal fade day-modal">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" align="left">Agregar Lotería y Parley</h4>
             
             {{ Form::open(array('route' => array('cuentas.createDay'))) }} 
                                                      
          </div>
          <div class="modal-body">
            <p>                    
<!-- Fecha .....................................................................-->  
                                <div class="row">
                                    <div class="col-md-5">
                                    {{ Form::label('fecha', 'Fecha') }}    
                                    </div>
                                    <div class="col-md-4">        
                                        <div class="input-prepend input-group">                                            
                                            <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                            <input type="text" style="width: 120px" name="fecha_day" id="fecha_day" class="form-control"  /> 
                                        </div> 
                                    </div>
                                </div>                                       
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#fecha_day').daterangepicker(
                                            { 
                                                singleDatePicker: true, 
                                                startDate: moment().subtract('days', 29),
                                                endDate: moment()
                                            }, function(start, end, label) {
                                        console.log(start.toISOString(), end.toISOString(), label);
                                        });
                                    });
                                </script>                                   
<!-- Agencia .....................................................................-->
                                <div class="row">
                                    <div class="col-md-5">
                                    {{ Form::label('agencia', 'Agencia') }}                                                
                                    </div>
                                    
                                    <div class="col-md-4">                                                    
                                            <select  class="selectpicker form-control" name="agencia3" id="agencia3" required="true" >                                         
                                            <option value=""></option>
                                            @foreach($agencias as $key => $value2)                                                       
                                                    <option value={{ $value2->nombre }}>{{ $value2->nombre }}</option>                                                
                                            @endforeach   
                                            </select>                                                    
                                    </div>
                                </div>                                    
<!-- Caja .....................................................................-->
                                <div class="row">
                                    <div class="col-md-5">
                                    {{ Form::label('caja', 'Caja') }}                                                
                                    </div>
                                    <div class="col-md-4">                                                    
                                             <input type="number" name="caja" id="caja" value = "" class="form-control"  required="true" autocomplete="off" >   
                                    </div>
                                </div>   
<!-- vParley  .....................................................................-->
                                <div class="row">
                                    <div class="col-md-5">
                                    {{ Form::label('vParley', 'Venta Parley') }}                                                
                                    </div>
                                    <div class="col-md-4">                                                    
                                             <input type="number" name="vParley" id="vParley" value = "" class="form-control"  required="true" autocomplete="off" >   
                                    </div>
                                </div>    
<!-- pParley .....................................................................-->
                                <div class="row">
                                    <div class="col-md-5">
                                    {{ Form::label('pParley', 'Premios Parley') }}                                                
                                    </div>
                                    <div class="col-md-4">                                                    
                                             <input type="number" name="pParley" id="pParley" value = "" class="form-control"  required="true" autocomplete="off" >   
                                    </div>
                                </div>    
<!-- vLoteria .....................................................................-->
                                <div class="row">
                                    <div class="col-md-5">
                                    {{ Form::label('vLoteria', 'Venta Loteria') }}                                                
                                    </div>
                                    <div class="col-md-4">                                                    
                                             <input type="number" name="vLoteria" id="vLoteria" value = "" class="form-control"  required="true" autocomplete="off" >   
                                    </div>
                                </div>    
<!-- pLoteria .....................................................................-->
                                <div class="row">
                                    <div class="col-md-5">
                                    {{ Form::label('pLoteria', 'Premios Loteria') }}                                                
                                    </div>
                                    <div class="col-md-4">                                                    
                                             <input type="number" name="pLoteria" id="pLoteria" value = "" class="form-control"  required="true" autocomplete="off" >   
                                    </div>
                                </div>    
<!-- vCopias .....................................................................-->
                                <div class="row">
                                    <div class="col-md-5">
                                    {{ Form::label('vCopias', 'Venta Copias') }}                                                
                                    </div>
                                    <div class="col-md-4">                                                    
                                             <input type="number" name="vCopias" id="vCopias" value = "" class="form-control"  required="true" autocomplete="off" >   
                                    </div>
                                </div>                                                                                                                                                                                           
<!-- BUTTONS .....................................................................-->
                    </p>
                </div>
                <div class="modal-footer">                                                                                            
                                                                                           
                <button type="submit" class="btn btn-primary" data-toggle="modal">Guardar</button>                                                    
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>   
                {{ Form::close() }}                                                                                                        
                </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->                
<!-- .................................................END DAY MODAL VIEW .................................................................................-->                                        