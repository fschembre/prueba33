<?php
class Preimpreso extends Eloquent {
    
    protected $table = 'preimpresos';

    public $restful = true;

    public static function MakeGrid()
    {                   
        $preimpresos = DB::table('preimpresos')->orderBy('id', 'desc')->get();
        
        echo "<div>";    
            echo "<table class='table table-striped table-hovered table-condensed'>
                    <thead>
                        <tr>
                            <td>id</td>                    
                            <td>Fecha</td>
                            <td>Producto</td>
                            <td>Agencia</td>
                            <td>Cantidad</td>
                            <td>Precio</td>                            
                            <td>Premio</td>                                   
                            <td>Saldo</td>                                   
                        </tr>
                    </thead>
                    <tbody>";
                     foreach ($preimpresos as $value) 
                    {
                        echo "<tr>";
                            echo "<td>".$value->id."</td>";
                            $fecha = date_create($value->fecha);
                            $fecha = date_format($fecha, 'd/m/Y');
                            echo "<td>".$fecha."</td>";
                            echo "<td>".$value->producto."</td>";
                            echo "<td>".$value->agencia."</td>";
                            echo "<td>".$value->cantidad."</td>";
                            echo "<td>".$value->precio."</td>";                        
                            echo "<td>".$value->premio."</td>";                        
                            $total = $value->precio*$value->cantidad-$value->premio;
                            echo "<td align='right'>".number_format($total, 0, '.', ',')."</td>";                            
                            //Insert Edit button
                            Preimpreso::EditButton($value->id);
                            //Insert Delete button
                            Preimpreso::DeleteButton($value->id);

                            echo "</tr>";
                    }
            echo    "</tbody>";          
            echo "</table>";
        echo "</div>";              
    }

    public static function EditButton($id)
    {
        
        $productos = DB::select('SELECT * FROM cmb_preimpresos');
        $agencias = DB::select('SELECT * FROM cmb_agencias');        
        $categorias = DB::select('SELECT * FROM cmb_categorias');   
        //$cuenta->id =$id;


        $preimpresos = DB::table('preimpresos')->where('id', $id)->get();      

        foreach ($preimpresos as $preimpreso){}

        echo"   
        <td align='right'>
            <div>
            <button class='btn btn-xs btn-warning' type='button' data-toggle='modal' data-target='.edit-modal".$id."' data-title='Edit' data-message='Edit?'>
                <i class='glyphicon glyphicon-pencil'></i> 
            </button>

        <!-- .................................................BEGIN MODAL VIEW ...............................................................................-->
        <div class='modal fade edit-modal".$id."'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                        <h4 class='modal-title' align='left'>Editar Preimpreso</h4>
                    </div> 
                    <form method='POST' action='http://fran/prueba29/public/pages/preimpresos/".$id."/update' accept-charset='UTF-8'>

                    <div class='modal-body'>
                    <p>                    
        <!-- Fecha .....................................................................--> 
                        <div class='row'>
                            <div class='col-md-5'>
                            ".Form::label('fecha', 'Fecha')."
                            </div>
                            <div class='col-md-4'>        
                                <div class='input-prepend input-group'>                                            
                                    <span class='add-on input-group-addon'><i class='glyphicon glyphicon-calendar fa fa-calendar'></i></span>
                                    <input type='text' style='width: 120px' name='fecha_add' id='fecha_add' class='form-control'  value = '".date('d-m-Y', strtotime($preimpreso->fecha))."'/> 
                                </div> 
                            </div>
                        </div>                                       
                        <script type='text/javascript'>
                            $(document).ready(function() {
                                $('#fecha_add').daterangepicker(
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
                        <div class='row'>
                            <div class='col-md-5'>
                            ".Form::label('agencia', 'Agencia')."
                            </div>                                                        
                            <div class='col-md-4'>                                                    
                                <select  name='agencia' class='selectpicker form-control' id='agencia'>";
                                    foreach($agencias as $key => $value2)
                                    {
                                        if ( $value2->nombre == strtolower( $preimpreso->agencia) )
                                             echo "<option value=".strtolower($value2->nombre)." selected>".$value2->nombre."</option>";
                                        else
                                            echo "<option value=".strtolower($value2->nombre).">".$value2->nombre."</option>";                                                                                                       
                                    }
        echo"  
                                </select>                                                    
                            </div>
                        </div>                             
        <!-- Producto .....................................................................-->
                        <div class='row'>
                            <div class='col-md-5'>
                            ".Form::label('producto', 'Producto')."
                            </div>
                            <div class='col-md-4'>                                                    
                                <select  class='selectpicker form-control' name='producto3' required='true' >                                         
                                    <option value=''></option>";
                                    foreach($productos as $key => $value2)
                                    {
                                        if ( strtolower( $value2->nombre) == strtolower($preimpreso->producto) ) 
                                            echo "<option value=".$value2->nombre." selected>".$value2->nombre."</option>";
                                        else
                                            echo "<option value=".$value2->nombre.">".$value2->nombre."</option>";                                                                                    
                                    }                        
        echo"
                                </select>                                                    
                            </div>
                        </div>                                            
        <!-- Cantidad .....................................................................-->
                        <div class='row'>
                            <div class='col-md-5'>
                             ".Form::label('cantidad', 'Cantidad')."
                            </div>
                            <div class='col-md-4'>                                                                                    
                                    
                                        <input type='number' name='cantidad' id='cantidad' value=".$preimpreso->cantidad." class='form-control'>                               
                                    
                            </div>
                        </div>     
        <!-- precio .....................................................................-->
                        <div class='row'>
                            <div class='col-md-5'>
                             ".Form::label('precio', 'precio')."
                            </div>
                            <div class='col-md-4'>                                                                                    
                                    
                                        <input type='number' name='precio' id='precio' value=".$preimpreso->precio." class='form-control'>                               
                                    
                            </div>
                        </div>     
        <!-- ..................................................................................-->        
                    </p>
                    </div> <!--Class modal-body -->
                    <div class='modal-footer'>                                                                                                                                                                                        
                        <button type='submit' class='btn btn-primary' data-toggle='modal'>Guardar</button>                                                    
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>   
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->                                                              
        <!-- .................................................END MODAL VIEW .................................................................................
        </div> <!-buttons -->
        </td>";                  
    }

    public static function DeleteButton($id)
    {
          echo" <td>
                    <div>
                       <button class='btn btn-xs btn-danger' type='button' data-toggle='modal' data-target='.delete-modal".$id."' data-title='Delete' data-message='Delete?'>
                           <i class='glyphicon glyphicon-trash'></i> 
                       </button>
                        <div class='modal fade delete-modal".$id."' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' >
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header' align='left'>
                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                        <h4 class='modal-title'>Eliminar</h4>
                                    </div>
                                <div class='modal-body' align='center'>
                                    <p>¿Está seguro que desea eliminar el registro <strong>".$id."</strong>?</p>
                                </div>
                                <div class='modal-footer'>";                                                     
                                    echo "<form method='POST' action='http://fran/prueba29/public/pages/preimpresos/".$id."/destroy' accept-charset='UTF-8'>";                                                                                     
                                    echo "  <button type='submit' class='btn btn-danger' data-toggle='modal'>Borrar</button>";
                                    echo "  <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>";
                                    echo "</form>";
                  echo"             </div>
                            </div>
                        </div>
                    </div>
                </td>";     
    }
}    