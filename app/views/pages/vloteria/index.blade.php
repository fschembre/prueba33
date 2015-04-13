@extends('layouts.default')
@section('content')

<?php $name = 'Lotería'; ?>
 <!-- Page Heading -->
  <div class="row">
      <div class="col-lg-12">
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
        
        $agencias = DB::select('SELECT * FROM cmb_agencias');        
        $categorias = DB::select('SELECT * FROM cmb_categorias');                
        $productos = DB::select('SELECT * FROM cmb_productos');  
     
        $sql = "SELECT * FROM vloteria ORDER BY id ASC";
        
        $data = DB::select($sql);  
        
        $data = DB::select('select * from vloteria where id = ?', array(1));

        $data = vLoteria::orderBy('id', 'DESC')->get();
?> 

<br>

{{ Form::open(array('url' => 'test')) }}      
<div class="well">
        <div class="col-sm-6 col-lg-3">            
          <div class="form-group">
            <button type="submit" value="" class="btn btn-success" type="submit" id="submit"><i class="glyphicon glyphicon-plus"></i> Agregar</button>                
        </div>  
       
</div>    <!-- End of well class   -->   
{{ Form::close() }}           

 

<div>
                                                               
         <style type='text/css'> .dataTables_filter { display: none; } </style> 
          <script type='text/javascript' language='javascript' class='init'>
        
            $(document).ready(function() {
                $('#one').dataTable( {
                    sDom: '\"top\"i',
                    autoWidth: true,
                    paging:   true,
                    ordering: false,
                    info:     false
                    
                } );
            } );
        </script>
        <table id='one' class='table table-striped table-bordered cell-border stripe row-border compact' width='100%' cellspacing='0'>
              <thead class='display cell-border'>
                  <tr>
                      <td>id</td>
                      <td>Fecha</td>
                      <td>Agencia</td>
                      <td>Venta</td>
                      <td>Premio</td>
                      <td></td>
                      <td></td>
                  </tr>
              </thead>
              <tbody>
             @foreach ($data as $value)             
                   <tr>                                         
                      <td><font color=black>{{ $value->id }}</font></td>
                      <td><font color=black>{{ $value->fecha }}</font></td>
                      <td>{{ $value->agencia }}</td>
                      <td align='right'>{{ number_format($value->venta, 0, '.', ',') }}</td>
                      <td align='right'>{{ number_format($value->premio, 0, '.', ',') }}</td>                  
                      <td width='1%' height='1%'><p onclick="edit{{ $value->id }}()"><button type='button' class='btn btn-warning btn-circle' data-toggle="modal" data-target=".edit-modal{{ $value->id }}"><i class='glyphicon glyphicon-edit'></i></button></td>
                      <td width='1%' height='1%'><p onclick="delete{{ $value->id }}()"><button type='button' class='btn btn-danger btn-circle' data-toggle="modal" data-target=".delete-modal{{ $value->id }}"><i class='glyphicon glyphicon-remove'></i></button></td>
                      
                      <td>
                          <div>
                             <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target=".delete-modal{{ $value->id }}" data-title="Delete" data-message="Delete?"><i class="glyphicon glyphicon-trash"></i> 
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

                      
                   

                  </tr>
              @endforeach
               
              </tbody>                                          
          </table>
       
</div>


      



<script type="text/javascript">
    $(document).ready(function() {
        $('#testdate').daterangepicker(
            { 
                singleDatePicker: true, 
                startDate: moment().subtract('days', 29),
                endDate: moment()
            }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>   
             

     

@stop