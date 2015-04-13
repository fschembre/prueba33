<?php

class PreimpresoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$Preimpresos = DB::table('Preimpresos')->paginate(10, array('id', 'fecha', 'agencia', 'cantidad', 'precio', 'premio'));
		$agencias = DB::select('SELECT * FROM cmb_agencias');
		$categorias = DB::select('SELECT * FROM cmb_categorias');
		$productos = DB::select('SELECT * FROM cmb_productos');
		$preimpresos = DB::select('SELECT * FROM cmb_preimpresos');

		return View::make('Preimpresos.index')
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
		$Preimpreso = Preimpreso::find($id);

		$Preimpreso->id =$id;
		$Preimpreso->fecha = Input::get('fecha_pre');
		$Preimpreso->fecha = date("Y-m-d", strtotime($Preimpreso->fecha));
		
		$Preimpreso->producto = strtolower( Input::get('producto_pre') );
		$Preimpreso->agencia = Input::get('agencia');
		$Preimpreso->cantidad = Input::get('cantidad');            
		$Preimpreso->precio = Input::get('precio');
		$Preimpreso->premio = Input::get('premio');		

		$Preimpreso->created_at = date("Y-m-d H:i:s");          
		$Preimpreso->updated_at = date("Y-m-d H:i:s");
		$Preimpreso->save();
		//$getLastPage = $Preimpreso->getCurrentPage();

		$url = 'preimpresos?page=' . Session::get('page_number');
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
		DB::delete('delete from Preimpresos where id = '.$id);

	 	$url = 'preimpresos';
		return Redirect::to($url);   
	}

	public function create()
	{
		$Preimpreso = new Preimpreso(); 

		$max = DB::table('preimpresos')->max('id');		
		$Preimpreso->id =$max+1;
		
		$fecha = Input::get('fecha_pre');
		$fecha = date("Y-m-d", strtotime($fecha));

		$Preimpreso->fecha = $fecha;
		$Preimpreso->producto = Input::get('producto_pre');
		$Preimpreso->agencia = Input::get('agencia_pre');
		$Preimpreso->cantidad = Input::get('cantidad_pre');            
		$Preimpreso->precio = Input::get('precio_pre');
		$Preimpreso->premio = Input::get('premio_pre');		

		$Preimpreso->created_at = date("Y-m-d H:i:s");          
		$Preimpreso->updated_at = date("Y-m-d H:i:s");
		$Preimpreso->save();

	 	$$url = 'preimpresos?page=' . Session::get('page_number');
		return Redirect::to($url);   
	}

	

	
}


