<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('login', 'AuthController@login');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('roles', 'AuthController@roles');
        Route::post('asignar_roles', 'AuthController@asignar_roles');
        Route::post('asignar_permisos', 'AuthController@asignar_permisos');
        Route::get('permisos', 'AuthController@permisos');
        Route::post('signup', 'AuthController@signup');

        //Modelos
        Route::resource('/ajuste', 'AjusteinvController');

        Route::resource('/cliente', 'ClienteController');
        Route::get('/clientes_borrados', 'ClienteController@indexDelete');

        Route::resource('/compra', 'CompraController');
        Route::get('/compras_borradas', 'CompraController@indexDelete');

        Route::resource('/configuracion', 'ConfiguracionController');
        Route::get('/configuraciones_borradas', 'ConfiguracionController@indexDelete');

        Route::resource('/departamento', 'DepartamentoController');
        Route::get('/departamentos_borrados', 'DepartamentoController@indexDelete');

        Route::resource('/mejormes', 'MejorMesController')->except(['create', 'edit', 'store']);
        Route::get('/mejormes', 'MejorMesController@store');

        Route::resource('/moneda', 'MonedaController');
        Route::get('/monedas_borradas', 'MonedaController@indexDelete');

        Route::resource('/producto', 'ProductoController');
        Route::get('/productos_borrados', 'ProductoController@indexDelete');

        Route::resource('/proveedor', 'ProveedorController');
        Route::get('/proveedores_borrados', 'ProveedorController@indexDelete');

        Route::resource('/tipo_producto', 'TipoProductoController');
        Route::get('/tipos_productos_borrados', 'TipoProductoController@indexDelete');
        
        Route::resource('/unidad', 'UnidadController');
        Route::get('/unidades_borradas', 'UnidadController@indexDelete');

        Route::resource('/cotizacion', 'CotizacionController');
        Route::get('/cotizaciones_borradas', 'CotizacionController@indexDelete');

        Route::resource('/factura', 'FacturaController');
        Route::get('/facturas_borradas', 'FacturaController@indexDelete');

        Route::resource('/ordencompra', 'OrdenCompraController');
        Route::get('/ordencompras_borradas', 'OrdenCompraController@indexDelete');

        Route::resource('/notasalida', 'NotaSalidaController');

        Route::resource('/tmp_cotizacion', 'Tmp_cotizacionController');

        Route::resource('/equilibrio', 'EquilibrioController');

        Route::resource('/dolar', 'DolarController');
        Route::get('/dolares_borrados', 'DolarController@indexDelete');


        //Configuraciones locales
        Route::post('setEmpresa', 'Conf_empresaController@setData');
        Route::get('getEmpresa', 'Conf_empresaController@getData');

        Route::post('setFactura', 'Conf_facturaController@setData');
        Route::get('getFactura', 'Conf_facturaController@getData');

        Route::post('setRegion', 'Conf_regionController@setData');
        Route::get('getRegion', 'Conf_regionController@getData');

        Route::post('setVenta', 'Conf_ventaController@setData');
        Route::get('getVenta', 'Conf_ventaController@getData');
    });
