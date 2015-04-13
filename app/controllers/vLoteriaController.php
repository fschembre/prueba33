<?php

class vLoteriaController.php extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$cuentas = DB::table('vloteria')->paginate(10, array('id', 'fecha', 'agencia', 'venta', 'prmeio'));
		$agencias = DB::select('SELECT * FROM cmb_agencias');
		$categorias = DB::select('SELECT * FROM cmb_categorias');
		$productos = DB::select('SELECT * FROM cmb_productos');
		$preimpresos = DB::select('SELECT * FROM cmb_preimpresos');

		return View::make('cuentas.index')
		->with('preimpresos', $preimpresos)
		->with('productos', $productos)
		->with('agencias', $agencias)
		->with('categorias', $categorias);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$cuenta = Cuenta::find($id);

		$cuenta->id =$id;
		$cuenta->fecha = Input::get('fecha');
		$cuenta->fecha = date("Y-m-d", strtotime($cuenta->fecha));
		$cuenta->producto = strtolower( Input::get('producto3') );
		$cuenta->agencia = Input::get('agencia');
		$cuenta->categoria = strtolower( Input::get('categoria') );
		$cuenta->descripcion = Input::get('descripcion');

		if (  $cuenta->categoria == 'venta' )
		{
			$cuenta->debe = Input::get('monto');
			$cuenta->haber = 0;
		}
		else 
		{
			$cuenta->debe = 0;
			$cuenta->haber = Input::get('monto');
		}			
               

		$cuenta->created_at = date("Y-m-d H:i:s");          
		$cuenta->updated_at = date("Y-m-d H:i:s");
		$cuenta->save();
		//$getLastPage = $cuenta->getCurrentPage();

		$url = 'cuentas?page=' . Session::get('page_number');
		return Redirect::to($url);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		DB::delete('delete from cuentas where id = '.$id);

	 	$url = 'cuentas?page=' . Session::get('page_number');
		return Redirect::to($url);   
	}


	public function createDay()
	{

		$fecha = Input::get('fecha_day');
		$fecha = date("Y-m-d", strtotime($fecha));

		$agencia = Input::get('agencia3');
		$producto = Input::get('producto');
		$caja = Input::get('caja');
		$vLoteria = Input::get('vLoteria');
		$pLoteria = Input::get('pLoteria');
		$vParley = Input::get('vParley');
		$pParley = Input::get('pParley');
		$vCopias = Input::get('vCopias');
		$vPreimpresos = Input::get('vPreimpresos');

		//Venta Loteria
		DB::insert('insert into cuentas (fecha, producto, agencia, categoria, descripcion, debe, haber, caja, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
						  array($fecha, "Loteria", $agencia, 'Venta', 'Venta Lotería', $vLoteria, 0, $caja, $fecha, $fecha ));
		//Premio Loteria
		DB::insert('insert into cuentas (fecha, producto, agencia, categoria, descripcion, debe, haber, caja, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
						  array($fecha, "Loteria", $agencia, 'Premio', 'Premio Lotería', 0, $pLoteria, $caja, $fecha, $fecha ));
		//Venta Parley
		DB::insert('insert into cuentas (fecha, producto, agencia, categoria, descripcion, debe, haber, caja, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
						  array($fecha, 'Parley', $agencia, 'Venta', 'Venta Parley', $vParley, 0, $caja, $fecha, $fecha ));
		//Premio Parley
		DB::insert('insert into cuentas (fecha, producto, agencia, categoria, descripcion, debe, haber, caja, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
						  array($fecha, 'Parley', $agencia, 'Premio', 'Premio Parley', 0, $pParley, $caja, $fecha, $fecha ));
		//Venta Copias
		DB::insert('insert into cuentas (fecha, producto, agencia, categoria, descripcion, debe, haber, caja, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
						  array($fecha, 'Copias', $agencia, 'Venta', 'Venta Copias', $vCopias, 0, $caja, $fecha, $fecha ));
		
	 	$url = 'cuentas?page=' . Session::get('page_number');
		return Redirect::to($url);   
	}

	public function createPreimpreso()
	{		
		$fecha = Input::get('fecha_pre');		
		$fecha = date("Y-m-d", strtotime($fecha) );

		$agencia = Input::get('agencia_pre');
		$producto = Input::get('producto_pre');
		$cantidad = Input::get('cantidad_pre');
		$precio = Input::get('precio_pre');

		$total = $cantidad*$precio;
		$caja = 0;

		DB::insert("insert into cuentas (fecha, producto, agencia, categoria, descripcion, debe, haber, caja, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", 
						  array($fecha, 'Preimpresos', $agencia, 'Venta', 'Venta Preimpresos '.$producto, $total, 0, $caja, $fecha, $fecha ) );
		DB::insert("insert into preimpresos (fecha, producto, agencia, cantidad, precio, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?)", 
						  array($fecha, 'Preimpresos', $agencia, $cantidad, $precio, $fecha, $fecha ) );

		$url = 'cuentas?page=' . Session::get('page_number');
		return Redirect::to($url);   
	}	
}


