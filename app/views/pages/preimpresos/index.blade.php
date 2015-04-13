@extends('layouts.default')
@section('content')



<?php $name = 'Preimpresos'; ?>
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
        $reporte = 'preimpresos';

        $agencias = DB::select('SELECT * FROM cmb_agencias');        
        $categorias = DB::select('SELECT * FROM cmb_categorias');                
        $productos = DB::select('SELECT * FROM cmb_preimpresos');  
        
        $preimpresos = DB::table('preimpresos')->orderBy('id', 'desc')->paginate(10);        
        
        $agencia = Input::get('agencia');
        $producto = Input::get('producto');        
        $cantidad = Input::get('cantidad');        
        $precio = Input::get('precio');        
        $premio = Input::get('premio');                        
        $reportrange = Input::get('reportrange');    
        $agrupar = Input::get('agrupar');                   
?> 

<br>
{{ Form::open(array('url' => $reporte)) }}


<a href="#" data-toggle="modal" data-target=".preimpreso-modal" data-title="Registro" data-message="Registro" class="btn btn-xs btn-success">
    <span class="glyphicon glyphicon-plus"></span> Agregar</a>

{{ Form::close() }}        


<div class="container-fluid">       
            <div >
            <p>
               <table class="table table-striped table-hovered table-condensed">
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
                    <tbody>
                        @foreach($preimpresos as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>                                 
                                    <td>{{ date("d/m/y", strtotime($value->fecha)) }}</td>
                                    <td>{{ $value->producto }}</td>                                    
                                    <td>{{ $value->agencia }}</td>                                    
                                    <td>{{ $value->cantidad }}</td>
                                    <td>{{ $value->precio }}</td>
                                    <td>{{ $value->premio }}</td>                                    
                                   
                                    <td align='right'>{{ number_format( $value->cantidad*$value->precio-$value->premio, 0, '.', ',') }}</td>                                                                                                        

<!-- .................................................EDIT BUTTON ...................................................................................
-->
                                 <td align="right">
                                    
                                        <div>
                                            <button class="btn btn-xs btn-warning" type="button" data-toggle="modal" data-target=".edit-modal{{ $value->id }}" data-title="Delete" data-message="Edit?">
                                            <i class="glyphicon glyphicon-pencil"></i> 
                                            </button>

<!-- .................................................BEGIN MODAL VIEW ...............................................................................
-->

                                            <div class="modal fade edit-modal{{ $value->id }}">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" align="left">Editar Preimpreso</h4>
                                                      </div>
                                                      

{{ Form::open(array('route' => array('preimpresos.update', $value->id))) }} 
                                                      
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
                                            <input type="text" style="width: 120px" name="fecha_pre" id="fecha_pre" class="form-control" value = {{ date('Y-m-d', strtotime($value->fecha)) }} /> 
                                        </div> 
                                    </div>
                                </div>                                       
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#fecha_pre').daterangepicker(
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
                                                                <select  class="selectpicker form-control" name="producto_pre" required="true" >                                         
                                                                <option value=""></option>
                                                                 @foreach($productos as $key => $value2)
                                                                    @if (strtolower($value2->nombre) == strtolower($value->producto) )
                                                                        <option value='{{ $value2->nombre }}' selected>{{ $value2->nombre }}</option>
                                                                    @else
                                                                        <option value='{{ $value2->nombre }}'>{{ $value2->nombre }}</option>
                                                                    @endif
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
                                                                <select  name="agencia" class="selectpicker form-control" id='agencia'>                                         
                                                                @foreach($agencias as $key => $value2)
                                                                    @if ($value2->nombre === $value->agencia)
                                                                        <option value={{ $value2->nombre }} selected>{{ $value2->nombre }}</option>
                                                                    @else
                                                                        <option value={{ $value2->nombre }}>{{ $value2->nombre }}</option>
                                                                    @endif
                                                                @endforeach   
                                                                </select>                                                    
                                                        </div>
                                                    </div>     
<!-- cantidad .....................................................................-->
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                        {{ Form::label('cantidad', 'cantidad') }}                                                
                                                        </div>
                                                        
                                                        <div class="col-md-4">                                                    
                                                                <input type='number' name='cantidad' id='cantidad' value= {{ $value->cantidad }} class='form-control'>                                                   
                                                        </div>
                                                    </div>     
<!-- precio .....................................................................-->
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                        {{ Form::label('precio', 'precio') }}                                                
                                                        </div>
                                                        <div class="col-md-4">  

                                                             <input type='number' name='precio' id='precio' value= {{ $value->precio }} class='form-control'>        
                                                        </div>
                                                    </div>                                            
<!-- premio .....................................................................-->
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                        {{ Form::label('premio', 'premio') }}                                                
                                                        </div>
                                                        <div class="col-md-4">  

                                                             <input type='number' name='premio' id='premio' value= {{ $value->premio }} class='form-control'>        
                                                        </div>
                                                    </div>         
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
<!-- .................................................END MODAL VIEW .................................................................................
-->



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
                                                                {{ Form::open(array('route' => array('preimpresos.destroy', $value->id))) }} 
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


<!-- ADD PREIMPRESO WINDOW ...................................................................-->
<!-- .................................................BEGIN MODAL VIEW ...............................................................................
-->

            <div class="modal fade preimpreso-modal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" align="left">Editar Preimpreso</h4>
                      </div>                      
                            {{ Form::open(array('route' => array('preimpresos.create', $value->id))) }}                       
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
                                        <input type="text" style="width: 120px" name="fecha_pre" id="fecha_pre" class="form-control" value = {{ date('Y-m-d', strtotime($value->fecha)) }} /> 
                                    </div> 
                                </div>
                                </div>                                       
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#fecha_pre').daterangepicker(
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
                                                                <select  class="selectpicker form-control" name="producto_pre" required="true" >                                         
                                                                <option value="" selected></option>
                                                                 @foreach($productos as $key => $value2)
                                                                   
                                                                       
                                                                        <option value='{{ $value2->nombre }}'>{{ $value2->nombre }}</option>
                                                                  
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
                                                                <select  name="agencia_pre" class="selectpicker form-control" id='agencia_pre'>  
                                                                <option value="" selected></option>                                       
                                                                @foreach($agencias as $key => $value2)
                                                                    
                                                                        <option value={{ $value2->nombre }}>{{ $value2->nombre }}</option>
                                                                    
                                                                @endforeach   
                                                                </select>                                                    
                                                        </div>
                                                    </div>     
<!-- cantidad .....................................................................-->
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                        {{ Form::label('cantidad', 'cantidad') }}                                                
                                                        </div>
                                                        
                                                        <div class="col-md-4">                                                    
                                                                <input type='number' name='cantidad_pre' id='cantidad_pre' value="'" class='form-control'>                                                   
                                                        </div>
                                                    </div>     
<!-- precio .....................................................................-->
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                        {{ Form::label('precio', 'precio') }}                                                
                                                        </div>
                                                        <div class="col-md-4">  

                                                             <input type='number' name='precio_pre' id='precio_pre' value="" class='form-control'>        
                                                        </div>
                                                    </div>                                            
<!-- premio .....................................................................-->
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                        {{ Form::label('premio', 'premio') }}                                                
                                                        </div>
                                                        <div class="col-md-4">  

                                                             <input type='number' name='premio_pre' id='premio_pre' value="" class='form-control'>        
                                                        </div>
                                                    </div>         
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
<!-- .................................................END MODAL VIEW ................................................................................. -->
<div align="center">

<?php
    //$preimpresos = cuenta::paginate(10);    
    $presenter = new Illuminate\Pagination\BootstrapPresenter($preimpresos);
        
      if ($preimpresos->getLastPage() > 1): ?>
          <div class="pagination" align="center">         
                  <?php echo getPrevious($preimpresos->getCurrentPage(), $preimpresos->getUrl( $preimpresos->getCurrentPage()-1 ) ) ?>
                  <?php echo $presenter->getPageRange(1, $preimpresos->getLastPage() ); ?>
                  <?php echo getNext($preimpresos->getCurrentPage(), $preimpresos->getLastPage(), $preimpresos->getUrl( $preimpresos->getCurrentPage()+1 ) )  ?>          
          </div>
          {{ Session::put('page_number', $preimpresos->getCurrentPage()); }}
          {{ Session::put('last_page', $preimpresos->getLastPage()); }}          
      
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