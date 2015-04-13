<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// Session Routes
Route::get('login',  array('as' => 'login', 'uses' => 'SessionController@create'));
Route::get('logout', array('as' => 'logout', 'uses' => 'SessionController@destroy'));
Route::resource('sessions', 'SessionController', array('only' => array('create', 'store', 'destroy')));

// User Routes
Route::get('register', 'UserController@create');
Route::get('users/{id}/activate/{code}', 'UserController@activate')->where('id', '[0-9]+');
Route::get('resend', array('as' => 'resendActivationForm', function()
{
	return View::make('users.resend');
}));
Route::post('resend', 'UserController@resend');
Route::get('forgot', array('as' => 'forgotPasswordForm', function()
{
	return View::make('users.forgot');
}));
Route::post('forgot', 'UserController@forgot');
Route::post('users/{id}/change', 'UserController@change');
Route::get('users/{id}/reset/{code}', 'UserController@reset')->where('id', '[0-9]+');
Route::get('users/{id}/suspend', array('as' => 'suspendUserForm', function($id)
{
	return View::make('users.suspend')->with('id', $id);
}));
Route::post('users/{id}/suspend', 'UserController@suspend')->where('id', '[0-9]+');
Route::get('users/{id}/unsuspend', 'UserController@unsuspend')->where('id', '[0-9]+');
Route::get('users/{id}/ban', 'UserController@ban')->where('id', '[0-9]+');
Route::get('users/{id}/unban', 'UserController@unban')->where('id', '[0-9]+');
Route::resource('users', 'UserController');
// Group Routes
Route::resource('groups', 'GroupController');



//App Routes
	Route::get('/', array('as' => 'home', function()
	{	return View::make('home'); }));

	Route::get('/home', array('as' => 'home', function()
	{	return View::make('home'); }));


	//Ventas
	Route::any('/vSemanas', array('as' => 'vSemanas', function()
	{	return View::make('pages.vSemanas');  }));
	//Route::get('vSemanas', array('as' => 'vSemanas.index', 'uses' => 'vSemanasController@index') );
	//Route::post('vSemanas', array('as' => 'vSemanas.prueba', 'uses' => 'vSemanasController@prueba') );


	Route::any('/vFechas', array('as' => 'vFechas', function()
	{	return View::make('pages.vFechas');  }));
	Route::any('/vAgencias', array('as' => 'vAgencias', function()
	{	return View::make('pages.vAgencias');  }));
	Route::any('/vProductos', array('as' => 'vProductos', function()
	{	return View::make('pages.vProductos');  }));
	Route::any('/vCustom', array('as' => 'vCustom', function()
	{	return View::make('pages.vCustom');  }));
	Route::any('/vPreimpresos', array('as' => 'vPreimpresos', function()
		{	return View::make('pages.vPreimpresos');  }));

	

	//Reportes
	Route::any('/rCostos', array('as' => 'rCostos', function()
		{	return View::make('pages.rCostos');  }));
	Route::any('/rGanancia', array('as' => 'rGanancia', function()
		{	return View::make('pages.rGanancia');  }));
	Route::any('/rResumen', array('as' => 'rResumen', function()
		{	return View::make('pages.rResumen');  }));

	Route::any('/rFechas', array('as' => 'rFechas', function()
	{	return View::make('pages.rFechas');  }));
	Route::any('/rAgencias', array('as' => 'rAgencias', function()
	{	return View::make('pages.rAgencias');  }));
	Route::any('/rProductos', array('as' => 'vProductos', function()
	{	return View::make('pages.rProductos');  }));
	Route::any('/rCustom', array('as' => 'rCustom', function()
	{	return View::make('pages.rCustom');  }));


	//Agregar
	Route::get('/cuentas', function()
	{	return View::make('pages.cuentas.index');   });
	Route::get('pages/cuentas/index', array('as' => 'cuentas.index', 'uses' => 'CuentaController@index') );
	Route::post('pages/cuentas/{id}/update', array('as' => 'cuentas.update', 'uses' => 'CuentaController@update') );
	Route::post('pages/cuentas/{id}/destroy',['as' => 'cuentas.destroy', 'uses' => 'CuentaController@destroy']);
	Route::post('pages/cuentas/createSingle',['as' => 'cuentas.createSingle', 'uses' => 'CuentaController@createSingle']);
	Route::post('pages/cuentas/createDay',['as' => 'cuentas.createDay', 'uses' => 'CuentaController@createDay']);
	Route::post('pages/cuentas/createPreimpreso',['as' => 'cuentas.createPreimpreso', 'uses' => 'CuentaController@createPreimpreso']);


	Route::get('/preimpresos', function()
	{	return View::make('pages.preimpresos.index');   });
	Route::get('pages/preimpresos/index', array('as' => 'preimpresos.index', 'uses' => 'PreimpresoController@index') );
	Route::post('pages/preimpresos/{id}/update', array('as' => 'preimpresos.update', 'uses' => 'PreimpresoController@update') );
	Route::post('pages/preimpresos/{id}/destroy',['as' => 'preimpresos.destroy', 'uses' => 'PreimpresoController@destroy']);
	Route::post('pages/preimpresos/create',['as' => 'preimpresos.create', 'uses' => 'PreimpresoController@create']);
	
	Route::get('/vloteria', function()
	{	return View::make('pages.vloteria.index');   });
	Route::get('pages/vloteria/index', array('as' => 'vloteria.index', 'uses' => 'vLoteriaController@index') );
	Route::post('pages/vloteria/{id}/update', array('as' => 'vloteria.update', 'uses' => 'vLoteriaController@update') );
	Route::post('pages/vloteria/{id}/destroy',['as' => 'vloteria.destroy', 'uses' => 'vLoteriaController@destroy']);
	Route::post('pages/vloteria/create',['as' => 'vloteria.create', 'uses' => 'vLoteriaController@create']);

	Route::get('TotalSales/{desde}/{hasta}/{producto}', function($desde, $hasta, $producto)
	{
		$sql="SELECT nombre, fecha, producto, agencia, sum(venta) as venta, (premio) as premio, (venta)-(premio) as saldo, 100*(premio)/(venta) as porcentaje from dias_de_la_semana AS A
		INNER JOIN (
		SELECT id, 'loteria' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vloteria union 
		SELECT id, 'parley' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vparley union 
		SELECT id, 'preimpreso' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vpreimpreso union
		SELECT id, 'copia' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcopia union
		SELECT id, 'caja' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcaja  
		) AS B ON A.id = B.dia	
		and fecha between '".$desde."' and '".$hasta."' ";

		if ($producto <> "")
				$sql = $sql."and producto = '".$producto."'	group by fecha order by fecha desc";			
		else
				$sql = $sql."group by fecha order by fecha desc";			

		$data = DB::select($sql); 	
		//echo json_encode($data);
		$num= count($data);

		echo "{ \"data\": [\n";
		$x=0;
		foreach($data as $key => $value)  
		{	
			echo "[\n";	                        
			echo "\"".$value->nombre."\", \n";
			echo "\"".$value->fecha."\", \n";
			//echo "\"".$value->producto."\", \n";
			//echo "\"".$value->agencia."\", \n";
			echo "\"".$value->venta."\", \n";		
			echo "\"".$value->premio."\" \n";
			$x++;
			
			if ($x < $num)
				echo "],\n";
			else
				echo "]\n";
		}
		echo "] }";
	});










Route::get('SalesLine', function(){
	$sql="select fecha as y, vloteria as a, vparley as b FROM (
	SELECT fecha, agencia, 
	MAX(IF(producto = 'lot', venta, NULL)) AS vLoteria, 
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
	SELECT 'lot' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vloteria union
	SELECT 'par' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vparley union
	SELECT 'pre' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vpreimpreso union
	SELECT 'cop' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcopia union
	SELECT 'caj' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcaja 
	) as a group by fecha 
	) as x";
	$data = DB::select($sql); 	echo json_encode($data);
});


Route::get('SalesArea', function(){
	$sql="select fecha as period, vloteria as a, vparley as b, vpreimpreso as c, vcopia as d FROM (
			select fecha, agencia, 
			MAX(IF(producto = 'lot', venta, NULL)) AS vLoteria, 
			MAX(IF(producto = 'par', venta, NULL)) AS vParley, 
			MAX(IF(producto = 'pre', venta, NULL)) AS vPreimpreso, 
			MAX(IF(producto = 'cop', venta, NULL)) AS vCopia,
			MAX(IF(producto = 'caj', venta, NULL)) AS vCaja,
			MAX(IF(producto = 'lot', premio, NULL)) AS pLoteria, 
			MAX(IF(producto = 'par', premio, NULL)) AS pParley, 
			MAX(IF(producto = 'pre', premio, NULL)) AS pPreimpreso, 
			MAX(IF(producto = 'cop', premio, NULL)) AS pCopia,
			MAX(IF(producto = 'caj', premio, NULL)) AS pCaja
		from (
		select 'lot' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vloteria union
		select 'par' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vparley union
		select 'pre' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vpreimpreso union
		select 'cop' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcopia union
		select 'caj' as producto, agencia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio  from vcaja 
		) as a group by fecha 
		) as x
		where fecha between '2014-08-01' and CURDATE()";
	$data = DB::select($sql); 	echo json_encode($data);
});

Route::get('Donut', function(){
	$sql = "select 100*sum(venta)/(select sum(venta) as total from (select sum(venta) as venta, 'loteria' from vloteria union 
select sum(venta) as venta, 'parley' from vparley union select sum(venta) as venta, 'preimpreso' from vpreimpreso union 
select sum(venta) as venta, 'copia' from vcopia) as x ) as value, 'loteria' as label from vloteria union 
select 100*sum(venta)/(select sum(venta) as total from (select sum(venta) as venta, 'loteria' from vloteria union 
select sum(venta) as venta, 'parley' from vparley union select sum(venta) as venta, 'preimpreso' from vpreimpreso union 
select sum(venta) as venta, 'copia' from vcopia) as x ) as value, 'parley' as label from vparley union
select 100*sum(venta)/(select sum(venta) as total from (select sum(venta) as venta, 'loteria' from vloteria union 
select sum(venta) as venta, 'parley' from vparley union select sum(venta) as venta, 'preimpreso' from vpreimpreso union 
select sum(venta) as venta, 'copia' from vcopia) as x ) as value, 'preimpreso' as label from vpreimpreso UNION 
select 100*sum(venta)/(select sum(venta) as total from (select sum(venta) as venta, 'loteria' from vloteria union 
select sum(venta) as venta, 'parley' from vparley union select sum(venta) as venta, 'preimpreso' 
from vpreimpreso union select sum(venta) as venta, 'copia' from vcopia) as x ) as value, 'copia' as label from vcopia";
	$data = DB::select($sql); 	echo json_encode($data);
});

Route::get('TotalSales/{desde}/{hasta}/{producto}', function($desde, $hasta, $producto)
{
	$sql="SELECT nombre, fecha, producto, agencia, sum(venta) as venta, (premio) as premio, (venta)-(premio) as saldo, 100*(premio)/(venta) as porcentaje from dias_de_la_semana AS A
			INNER JOIN (
			SELECT id, 'loteria' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vloteria union 
			SELECT id, 'parley' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vparley union 
			SELECT id, 'preimpreso' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vpreimpreso union
			SELECT id, 'copia' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcopia union
			SELECT id, 'caja' as producto, agencia, weekday(fecha) as dia, fecha, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcaja  
			) AS B ON A.id = B.dia	
			and fecha between '".$desde."' and '".$hasta."' ";
	
	if ($producto <> "")
			$sql = $sql."and producto = '".$producto."'	group by fecha order by fecha desc";			
	else
			$sql = $sql."group by fecha order by fecha desc";			

	$data = DB::select($sql); 	
	//echo json_encode($data);

	$num= count($data);

	echo "{ \"data\": [\n";
	$x=0;
	foreach($data as $key => $value)  
	{	
		echo "[\n";	                        
		echo "\"".$value->nombre."\", \n";
		echo "\"".$value->fecha."\", \n";
		//echo "\"".$value->producto."\", \n";
		//echo "\"".$value->agencia."\", \n";
		echo "\"".$value->venta."\", \n";		
		echo "\"".$value->premio."\" \n";
		$x++;
		
		if ($x < $num)
			echo "],\n";
		else
			echo "]\n";
	}
	echo "] }";
});

Route::get('ResumenSales/{desde}/{hasta}/{agencia}', function($desde, $hasta, $agencia)
{
	$sql="	SELECT nombre, fecha, agencia, 
	ifnull(MAX(IF(producto = 'lot', venta, NULL)), 0) AS vLoteria, 
	ifnull(MAX(IF(producto = 'par', venta, NULL)), 0) AS vParley, 
	ifnull(MAX(IF(producto = 'pre', venta, NULL)), 0) AS vPreimpreso, 
	ifnull(MAX(IF(producto = 'cop', venta, NULL)), 0) AS vCopia,
	ifnull(MAX(IF(producto = 'caj', venta, NULL)), 0) AS vCaja,
	ifnull(MAX(IF(producto = 'lot', premio, NULL)), 0) AS pLoteria, 
	ifnull(MAX(IF(producto = 'par', premio, NULL)), 0) AS pParley, 
	ifnull(MAX(IF(producto = 'pre', premio, NULL)), 0) AS pPreimpreso, 
	ifnull(MAX(IF(producto = 'cop', premio, NULL)), 0) AS pCopia,
	ifnull(MAX(IF(producto = 'caj', premio, NULL)), 0) AS pCaja
	FROM (
	SELECT 'lot' as producto, agencia, fecha, weekday(fecha) as dia, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vloteria union
	SELECT 'par' as producto, agencia, fecha, weekday(fecha) as dia, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vparley union
	SELECT 'pre' as producto, agencia, fecha, weekday(fecha) as dia, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vpreimpreso union
	SELECT 'cop' as producto, agencia, fecha, weekday(fecha) as dia, ifnull(venta,0) as venta, ifnull(premio,0) as premio from vcopia union
	SELECT 'caj' as producto, agencia, fecha, weekday(fecha) as dia, ifnull(venta,0) as venta, ifnull(premio,0) as premio  from vcaja 
	) as A inner join dias_de_la_semana as B on A.dia = B.id	
	where fecha between '".$desde."' and '".$hasta."' ";

	if ($agencia <> "none")
			$sql = $sql."and agencia = '".$agencia."'	group by fecha order by fecha desc";			
	else
			$sql = $sql."group by fecha order by fecha desc";			

	$data = DB::select($sql); 	
	//echo json_encode($data);

	$num= count($data);

	echo "{ \"data\": [\n";
	$x=0;
	foreach($data as $key => $value)  
	{	
		echo "[\n";	                        
		echo "\"".$value->nombre."\", \n";
		echo "\"".$value->fecha."\", \n";
		echo "\"".$value->agencia."\", \n";
	/*	echo "\"".$value->vLoteria."\", \n";		
		echo "\"".$value->pLoteria."\", \n";		
		echo "\"".$value->vPreimpreso."\", \n";		
		echo "\"".$value->pPreimpreso."\", \n";		
		echo "\"".$value->vParley."\", \n";		
		echo "\"".$value->pParley."\", \n";		
		echo "\"".$value->vCopia."\", \n";
		echo "\"".$value->pCopia."\", \n";
		echo "\"".$value->vCaja."\", \n";		
		echo "\"".$value->pCaja."\" \n";
*/		
		$x++;
		
		if ($x < 2)
			echo "],\n";
		else
			echo "]\n";
	}
	echo "] }";
});





// App::missing(function($exception)
// {
//     App::abort(404, 'Page not found');
//     //return Response::view('errors.missing', array(), 404);
// });















	Route::any('/consultas', array('as' => 'consultas', function()
	{	return View::make('pages.consultas');  }));

	Route::any('/test', array('as' => 'test', function()
	{	return View::make('pages.test');      }));








// App::missing(function($exception)
// {
//     App::abort(404, 'Page not found');
//     //return Response::view('errors.missing', array(), 404);
// });



Route::get('Saldo', function(){
	$sql="select  fecha as period, 
		venta-premio-dPreimpreso-cloteria-cparley-cpreimpreso-gasto as a from ( 
		select fecha, agencia, 
		ifnull(vloteria, 0) + ifnull(vparley, 0) + ifnull(vpreimpreso, 0) + ifnull(vcopia, 0) as venta, ifnull(ploteria, 0) + ifnull(pparley, 0) + ifnull(ppreimpreso, 0) + 
		ifnull(pcopia, 0) as premio, ifnull(vpreimpreso, 0)*0.75 as dPreimpreso, ifnull(vloteria, 0)*0.02 as cloteria, ifnull(vparley, 0)*0.02 as cparley, 
		ifnull(vpreimpreso, 0)*0.005 as cPreimpreso, ifnull(pCaja, 0) as gasto FROM ( SELECT fecha, agencia, MAX(IF(producto = 'lot', venta, 0)) AS vLoteria, 
		MAX(IF(producto = 'par', venta, 0)) AS vParley, 
		MAX(IF(producto = 'pre', venta, 0)) AS vPreimpreso, 
		MAX(IF(producto = 'cop', venta, 0)) AS vCopia, 
		MAX(IF(producto = 'caj', venta, 0)) AS vCaja, 
		MAX(IF(producto = 'lot', premio, 0)) AS pLoteria, 
		MAX(IF(producto = 'par', premio, 0)) AS pParley, 
		MAX(IF(producto = 'pre', premio, 0)) AS pPreimpreso, 
		MAX(IF(producto = 'cop', premio, 0)) AS pCopia, 
		MAX(IF(producto = 'caj', premio, 0)) AS pCaja FROM ( 
		SELECT 'lot' as producto, agencia, fecha, sum(ifnull(venta,0)) as venta, sum(ifnull(premio,0)) as premio from vloteria group by fecha union 
		SELECT 'par' as producto, agencia, fecha, sum(ifnull(venta,0)) as venta, sum(ifnull(premio,0)) as premio from vparley group by fecha union 
		SELECT 'pre' as producto, agencia, fecha, sum(ifnull(venta,0)) as venta, sum(ifnull(premio,0)) as premio from vpreimpreso group by fecha union 
		SELECT 'cop' as producto, agencia, fecha, sum(ifnull(venta,0)) as venta, sum(ifnull(premio,0)) as premio from vcopia group by fecha union 
		SELECT 'caj' as producto, agencia, fecha, sum(ifnull(venta,0)) as venta, sum(ifnull(premio,0)) as premio from vcaja group by fecha 
		) as x group by fecha ) as y ) as z 
		left join dias_de_la_semana on weekday(fecha) = dias_de_la_semana.id where fecha between '2014-08-01' AND curdate() order by fecha desc";
		$data = DB::select($sql); 	echo json_encode($data);
});


