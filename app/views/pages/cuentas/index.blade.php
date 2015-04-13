@extends('layouts.default')
@section('content')

<?php $name = 'Registros'; ?>
  <!-- Page Heading -->
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">
              {{ $name }}
          </h1>
          <ol class="breadcrumb">
              <li>
                  <i class="fa fa-dashboard"></i>  <a href="home">Principal</a>
              </li>
              <li>
                  <i class="fa fa-plus"></i>  Agregar
              </li>
              <li class="active">
                  <i class="fa fa-edit"></i> {{ $name }}
              </li>
          </ol>
      </div>
  </div>  <!-- /.row -->

<?php
        $reporte = 'cuentas';

        $agencias = DB::select('SELECT * FROM cmb_agencias');        
        $categorias = DB::select('SELECT * FROM cmb_categorias');                
        $productos = DB::select('SELECT * FROM cmb_productos');  
        
        $cuentas = DB::table('cuentas')->orderBy('id', 'desc')->Paginate(10);
        //$cuentas = cuenta::paginate(10);            
        $agencia = Input::get('agencia');
        $producto = Input::get('producto');        
        $cantidad = Input::get('cantidad');        
        $precio = Input::get('precio');        
        $premio = Input::get('premio');                        
        $reportrange = Input::get('reportrange');    
        $agrupar = Input::get('agrupar');                   
?> 

<br>



<div class="container-fluid">       
    {{ Form::open(array('url' => $reporte)) }}


<a href="#" data-toggle="modal" data-target=".add-modal" data-title="Registro" data-message="Registro" class="btn btn-xs btn-success">
    <span class="glyphicon glyphicon-plus"></span> Agregar</a>

{{ Form::close() }}        
            <div>
            <p>
                <table class="table table-striped table-hovered table-condensed">
                    <thead>
                        <tr>
                            <td>id</td>                    
                            <td>Fecha</td>
                            <td>Producto</td>
                            <td>Agencia</td>
                            <td>Categoria</td>
                            <td>Descripcion</td>                            
                            <td>Debe</td>                                   
                            <td>Haber</td>                                   
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuentas as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>                                         
                                    <td>{{ date("d/m/y", strtotime($value->fecha)) }}</td>                                    
                                    <td>{{ $value->producto }}</td>                                    
                                    <td>{{ $value->agencia }}</td>                                    
                                    <td>{{ $value->categoria }}</td>
                                    <td>{{ $value->descripcion }}</td>
                                    <td align='right'>{{ number_format($value->debe, 0, '.', ',') }}</td>                                                                    
                                    <td align='right'>{{ number_format($value->haber, 0, '.', ',') }}</td>      


<!-- .................................................DELETE BUTTON ...................................................................................
-->
                                            <td>
                                                <div>
                                                   <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target=".delete-modal{{ $value->id }}" data-title="Delete" data-message="Delete?">
                                                       <i class="glyphicon glyphicon-trash"></i> 
                                                   </button>

                                                    <div class="modal fade delete-modal{{ $value->id }}" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header" align="left">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <h4 class="modal-title">Eliminar</h4>
                                                                </div>
                                                            <div class="modal-body" align="center">
                                                                <p>¿Está seguro que desea eliminar el registro <strong>{{ $value->id }}</strong>?</p>
                                                            </div>
                                                            <div class="modal-footer">                                                                                                            
                                                                {{ Form::open(array('route' => array('cuentas.destroy', $value->id))) }} 
                                                                <button type="submit" class="btn btn-danger" data-toggle="modal">Borrar</button>                                                    
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                                                                                                          
                                                                {{ Form::close() }} 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>     

                                        </div>        
                                    </td>
                                </tr>                        
                        @endforeach
                    </tbody>
                </table>
            </p>
            </div>            
        
    </div>


<!-- ADD MODAL WINDOW ...................................................................-->
<!-- .................................................BEGIN MODAL VIEW .................................................................................-->
<div class="modal fade add-modal">    
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" align="left">Agregar Registro (Gasto, nómina, etc...)</h4>    
             
             {{ Form::open(array('route' => array('cuentas.createSingle'))) }} 
          
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
                                            <input type="text" style="width: 120px" name="fecha_add" id="fecha_add" class="form-control"  /> 
                                        </div> 
                                    </div>
                                </div>                                       
                                <script type="text/javascript">
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
<!-- Producto .....................................................................-->
                        <div class="row">
                            <div class="col-md-5">
                            {{ Form::label('producto', 'Producto') }}                                                
                            </div>
                            
                            <div class="col-md-4">                                                    
                                    <select  class="selectpicker form-control" name="producto2" required="true" >                                         
                                    <option value=""></option>
                                    @foreach($productos as $key => $value2)                                                       
                                            <option value={{ $value2->nombre }}>{{ $value2->nombre }}</option>                                                
                                    @endforeach   
                                    </select>                                                    
                            </div>
                        </div>                                                                                
<!-- Agencia .....................................................................-->
                        <div class="row">
                            <div class="col-md-5">
                            {{ Form::label('agencia', 'Agencia') }}                                                
                            </div>
                            
                            <div class="col-md-4">                                                    
                                    <select  class="selectpicker form-control" name="agencia2" required="true" >                                         
                                    <option value=""></option>
                                    @foreach($agencias as $key => $value2)                                                       
                                            <option value={{ $value2->nombre }}>{{ $value2->nombre }}</option>                                                
                                    @endforeach   
                                    </select>                                                    
                            </div>
                        </div>                                    
<!-- Categoria .....................................................................-->
                        <div class="row">
                            <div class="col-md-5">
                            {{ Form::label('categoria', 'Categoria') }}                                                
                            </div>
                            <div class="col-md-4">                                                    
                                    <select class="selectpicker form-control" name="categoria2" required="true" >                                         
                                            <option value=""></option>
                                    @foreach($categorias as $key => $value2)                                                      
                                            <option value={{ $value2->nombre }} >{{ $value2->nombre }}</option>                                                     
                                    @endforeach   
                                    </select>                                                                                               
                            </div>
                        </div>                                          
<!-- Monto .....................................................................-->
                        <div class="row">
                            <div class="col-md-5">
                            {{ Form::label('monto', 'Monto') }}                                                
                            </div>
                            <div class="col-md-4">                                                    
                                     <input type="number" name="monto2" id="monto2" value = "" class="form-control"  required="true" autocomplete="off" >   
                            </div>
                        </div>    
<!-- Descripcion .....................................................................-->        
                        <div class="row">
                            <div class="col-md-5">
                            {{ Form::label('descripcion', 'Descripcion') }}    
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                   <input type='text' name='descripcion2' id='descripcion2'  value= '' class='form-control' required='true' autocomplete="off">
                                </div>
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
<!-- .................................................END MODAL VIEW .................................................................................-->
<div align="center">

<?php
    //$cuentas = cuenta::paginate(10);    
    $presenter = new Illuminate\Pagination\BootstrapPresenter($cuentas);
        
      if ($cuentas->getLastPage() > 1): ?>
          <div class="pagination" align="center">         
                  <?php echo getPrevious($cuentas->getCurrentPage(), $cuentas->getUrl( $cuentas->getCurrentPage()-1 ) ) ?>
                  <?php echo $presenter->getPageRange(1, $cuentas->getLastPage() ); ?>
                  <?php echo getNext($cuentas->getCurrentPage(), $cuentas->getLastPage(), $cuentas->getUrl( $cuentas->getCurrentPage()+1 ) )  ?>          
          </div>
          {{ Session::put('page_number', $cuentas->getCurrentPage()); }}
          {{ Session::put('last_page', $cuentas->getLastPage()); }}          
      
      <?php endif; ?>

</div>
</body>
</html>

<?php
    function getPrevious($currentPage, $url)
    {
        if ($currentPage <= 1)
            return '<li class="previous disabled"><span class="icon-chevron-left"></span></li>';
        else
           return '<li class="previous"><a class="icon-chevron-left" href="'.$url.'"></a></li>';
    }

    function getNext($currentPage, $lastPage, $url)
    {
        if ($currentPage >= $lastPage)
            return '<li class="next disabled"><span class="icon-chevron-right"></span></li>';
        else
            return '<li class="next"><a class="icon-chevron-right" href="'.$url.'"></a></li>';
    }
?>
</div>

@stop