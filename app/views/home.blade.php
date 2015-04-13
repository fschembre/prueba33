@extends('layouts.default')
{{-- Web site Title --}}
@section('title')
@parent
{{trans('pages.helloworld')}}
@stop

{{-- Content --}}
@section('content')


    <?php $host =$_SERVER['REMOTE_ADDR']; ?>

        <div id="container">      
            <div class='esquina' style="float: right;">         
                Usuario: {{ Session::get('email') }}<br>
                IP: <?php echo $_SERVER['REMOTE_ADDR']; ?><br>
            </div>          
            <div align="left">
                
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="home">Principal</a>
                    </li>
                </ol>
            </div>      
        </div>

    
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
            <!--    <div id="chart" style="height: 250px;"></div>   -->

                        <div class="panel panel-default" width= "100%">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Venta Total</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart">
                                    <div id="SalesArea" style="height: 250px;"></div>
                                </div>

                            </div>
                        </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Ventas por Producto</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-chart">
                                    <div id="donut" style="height: 250px;"></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Saldo</h3>
                            </div>
                            <div class="panel-body">                                
                                    <div id="morris-area-chart">
                                        <div id="Saldo" style="height: 250px;"></div>
                                    </div>
                             </div>
                         </div>
                    </div>
                </div>
                <!-- /.row -->


            




    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-ok"></span> {{ trans('pages.loginstatus') }} </h3>
        
    </div>

@include('includes.charts')

@stop


