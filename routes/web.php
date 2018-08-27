<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
Route::get('/datospersona', ['uses' => 'HomeController@datospersona', 'as' => 'datospersona']);
Route::get('/gracias', ['uses' => 'HomeController@gracias', 'as' => 'gracias']);
Route::post('/enviarcorreosugerencia', ['uses' => 'HomeController@enviarcorreosugerencia', 'as' => 'enviarcorreosugerencia']);
Route::get('/cliente', ['uses' => 'HomeController@cliente', 'as' => 'cliente']);
Route::get('/cliente/app/{any}', 'HomeController@appcliente')->name('appcliente')->where('any', '.*')->middleware('auth');

Route::get('/pedidolisto', ['uses' => 'HomeController@pedidolisto', 'as' => 'pedidolisto']);
Route::post('/clienteescaner', ['uses' => 'HomeController@clienteescaner', 'as' => 'clienteescaner']);
Route::post('/cliente/guardarpedido',['uses' => 'HomeController@guardarpedidocliente', 'as' => '/cliente/guardarpedido'])->middleware('auth')->middleware('role:Cliente');

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');
Route::get('clientesalir', 'Auth\SocialAuthController@clientesalir')->name('clientesalir')->middleware('auth');
Route::get('/privacidad', ['uses' => 'HomeController@PolicticaPrivacidad', 'as' => 'privacidad']);

Route::get('/landing-page', ['uses' => 'HomeController@landingpage', 'as' => 'landing-page']);
Route::post('/postprueba', ['uses' => 'HomeController@postprueba', 'as' => 'postprueba']);

Route::middleware([\App\Http\Middleware\autenticacion::class])->group(function () {
    Route::get('/logout', 'Auth\LoginController@logout')->middleware('role:Admin|Mesero|Cocina|Caja'); // Finalizar sesión
    Route::get('/home', ['uses' => 'homeprincipalController@index', 'as' => 'home']);
    //productos
    Route::get('/productos', ['uses' => 'productoController@index', 'as' => '/productos'])->middleware('role:Admin');
    //invetntario
    Route::get('/inventario', ['uses' => 'inventarioController@index', 'as' => '/inventario'])->middleware('role:Admin');
    Route::post('/inventario.guardar', ['uses' => 'inventarioController@guardarinventario', 'as' => '/inventario.guardar'])->middleware('role:Admin');
    Route::get('/inventario.productos', ['uses' => 'inventarioController@productos', 'as' => '/inventario.productos'])->middleware('role:Admin');
    Route::post('/inventario.productosguardar', ['uses' => 'inventarioController@guardarinventarioproductos', 'as' => '/inventario.productosguardar'])->middleware('role:Admin');
    Route::get('/inventario.productoprecio', ['uses' => 'inventarioController@productoprecio', 'as' => '/inventario.productoprecio'])->middleware('role:Admin');
    Route::post('/inventario.consultarprecio', ['uses' => 'inventarioController@consultarprecio', 'as' => '/inventario.consultarprecio'])->middleware('role:Admin');
    Route::get('/inventario.verinventario', ['uses' => 'inventarioController@verinventario', 'as' => '/inventario.verinventario'])->middleware('role:Admin');


    //menu
    Route::get('/menu/{opcion}', ['uses' => 'menuController@index', 'as' => '/menu/{opcion}'])->middleware('role:Admin');
    Route::post('/menu.guardarmenu', ['uses' => 'menuController@guardarmenu', 'as' => '/menu.guardarmenu'])->middleware('role:Admin');
    Route::post('/menu.guardarplato', ['uses' => 'menuController@guardarplato', 'as' => '/menu.guardarplato'])->middleware('role:Admin');
    Route::post('/menu.actualizarmenu/{opcion}/{id}', ['uses' => 'menuController@actualizarmenu', 'as' => '/menu.actualizarmenu/{opcion}/{id}'])->middleware('role:Admin');
    Route::post('/menu.eliminar', ['uses' => 'menuController@eliminar', 'as' => '/menu.eliminar'])->middleware('role:Admin');
    Route::post('/menu.estado', ['uses' => 'menuController@estado', 'as' => '/menu.estado'])->middleware('role:Admin');
    Route::post('/menu.asociarplato', ['uses' => 'menuController@asociarplato', 'as' => '/menu.asociarplato'])->middleware('role:Admin');
    Route::post('/menu.listadeplatosmenu', ['uses' => 'menuController@listadeplatosmenu', 'as' => '/menu.listadeplatosmenu'])->middleware('role:Admin');

    //estadisticas
    Route::get('/estadisticas', ['uses' => 'estadisticasController@index', 'as' => '/estadisticas'])->middleware('role:Admin');
    Route::post('/consultardatos', ['uses' => 'estadisticasController@consultardatos', 'as' => '/consultardatos'])->middleware('role:Admin');

    //mesas
    Route::get('/mesas', ['uses' => 'menuController@mesas', 'as' => '/mesas'])->middleware('role:Admin');
    Route::post('/mesaseliminar/{id}', ['uses' => 'menuController@mesaseliminar', 'as' => '/mesaseliminar/{id}'])->middleware('role:Admin');
    Route::post('/mesaguardar', ['uses' => 'menuController@mesaguardar', 'as' => '/mesaguardar'])->middleware('role:Admin');
    Route::post('/mesaactualizar', ['uses' => 'menuController@mesaactualizar', 'as' => '/mesaactualizar'])->middleware('role:Admin');
    Route::get('/descargarqrcode', ['uses' => 'menuController@descargarqrcode', 'as' => '/descargarqrcode'])->middleware('role:Admin');

    //usuarios
    Route::get('/usuarios', ['uses' => 'usuariosController@index', 'as' => '/usuarios'])->middleware('role:Admin');
    Route::post('/usuarios.guardarusuario', ['uses' => 'usuariosController@guardarusuario', 'as' => '/usuarios.guardarusuario'])->middleware('role:Admin');
    Route::delete('/usuarios.eliminarusuario/{id}', ['uses' => 'usuariosController@eliminarusuario', 'as' => '/usuarios.eliminarusuario/{id}'])->middleware('role:Admin');
    Route::post('/usuarios.editarusuario/{id}', ['uses' => 'usuariosController@editarusuario', 'as' => '/usuarios.editarusuario/{id}'])->middleware('role:Admin');

    //otros usuarios
    Route::get('/otherusuarios.listarplatos', ['uses' => 'otherusuariosController@index', 'as' => 'otherusuarios.listarplatos'])->middleware('role:Caja|Mesero|Cocina');
    Route::get('/otherhome', ['uses' => 'otherusuariosController@index', 'as' => '/otherhome'])->middleware('role:Mesero|Cocina|Caja');
    Route::post('/otherhome.listarmenuplatos', ['uses' => 'otherusuariosController@listarmenuplatos', 'as' => '/otherhome.listarmenuplatos'])->middleware('role:Caja|Mesero|Cocina|Cliente');
    Route::post('/otherhome.guardarpedido', ['uses' => 'otherusuariosController@guardarpedido', 'as' => '/otherhome.guardarpedido'])->middleware('role:Mesero|Cocina');
    Route::post('/otherhome.listarpedidos', ['uses' => 'otherusuariosController@listarpedidos', 'as' => '/otherhome.listarpedidos'])->middleware('role:Cocina');
    Route::post('/otherhome.listarpedidoscaja', ['uses' => 'otherusuariosController@listarpedidoscaja', 'as' => '/otherhome.listarpedidoscaja'])->middleware('role:Caja');
    Route::post('/otherhome.guardarfactura', ['uses' => 'otherusuariosController@guardarfactura', 'as' => '/otherhome.guardarfactura'])->middleware('role:Caja');
    Route::post('/otherhome.listapedidos', ['uses' => 'otherusuariosController@listapedidos', 'as' => '/otherhome.listapedidos'])->middleware('role:Mesero');

    //mesero
    Route::post('/mesero.guardarpedido', ['uses' => 'otherusuariosController@guardarpedido', 'as' => '/mesero.guardarpedido']);
    //cargar combos
    Route::get('/cargarcombos', ['uses' => 'productoController@cargarcombos', 'as' => '/cargarcombos']);
    //guardados ajax
    Route::post('/guardarajax', ['uses' => 'productoController@guardarajax', 'as' => '/guardarajax']);
    // Notifications
    Route::post('notifications', 'NotificationController@store')->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::get('notifications', 'NotificationController@index')->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::get('notifications/last', 'NotificationController@last')->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::patch('notifications/{id}/read', 'NotificationController@markAsRead')->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::post('notifications/mark-all-read', 'NotificationController@markAllRead')->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::post('notifications/{id}/dismiss', 'NotificationController@dismiss')->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::post('notificacion.oferta', ['uses' => 'NotificationController@enviarnotificaciones', 'as' => 'notificacion.oferta'])->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::get('notifications/all', ['uses' => 'NotificationController@notificacionall', 'as' => '/notifications/all'])->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::post('notifications/postall', ['uses' => 'NotificationController@notificacionpostall', 'as' => '/notifications/postall'])->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::patch('notifications/delete', ['uses' => 'NotificationController@notificaciondelete', 'as' => '/notifications/delete'])->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::post('notifications/deleteall', ['uses' => 'NotificationController@notificaciondeleteall', 'as' => '/notifications/deleteall'])->middleware('role:Admin|Caja|Mesero|Cocina');

    // Push Subscriptions
    Route::post('subscriptions', 'PushSubscriptionController@update')->middleware('role:Admin|Caja|Mesero|Cocina');
    Route::post('subscriptions/delete', 'PushSubscriptionController@destroy')->middleware('role:Admin|Caja|Mesero|Cocina');
});