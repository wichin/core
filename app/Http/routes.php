<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get ('/login','LoginController@Index');
Route::post('/login','LoginController@Index');

Route::group(['middleware' => ['sesion']], function () {
    Route::get ('/inicio','LoginController@Init');

    Route::group(['prefix' => 'admin','namespace' => 'Modulos\Administracion'], function()
    {
        Route::group(['prefix' => 'sistema'], function()
        {
            Route::get ('modulo','SistemaController@InitModulo');
            Route::post('modulo','SistemaController@InitModulo');
            Route::post('accionModulo','SistemaController@InitAccionModulo');

            Route::get ('menu','SistemaController@InitMenu');
            Route::post('menu','SistemaController@InitMenu');
            Route::post('accionMenu','SistemaController@InitAccionMenu');

            Route::get ('aplicacion','SistemaController@InitAplicacion');
            Route::post('aplicacion','SistemaController@InitAplicacion');
            Route::post('buscarMenu','SistemaController@InitBuscarMenu');
            Route::post('accionAplicacion','SistemaController@InitAccionAplicacion');
        });

        Route::group(['prefix' => 'usuario'], function()
        {
            Route::get ('/gestion','UsuarioController@InitGestion');
            Route::post('/gestion','UsuarioController@InitGestion');

            Route::get ('/listar','UsuarioController@InitListar');
            Route::post('/accion','UsuarioController@InitAccion');
            Route::post('/permisos','UsuarioController@InitPermisos');
            Route::post('/saveAccess','UsuarioController@InitSaveAccess');
        });
    });

    Route::group(['prefix' => 'miembros','namespace' => 'Modulos\Miembros'], function()
    {
        Route::group(['prefix' => 'gestion'], function()
        {
            Route::get ('/agregar','GestionController@InitAgregar');
            Route::post('/agregar','GestionController@InitAgregar');

            Route::get ('/listar','GestionController@InitListar');
            Route::post('/listar','GestionController@InitListar');

            Route::get ('/buscar','GestionController@InitBuscarPersona');
            Route::get ('/busquedaGeneral','GestionController@InitBusquedaGeneral');
        });
    });

    Route::group(['prefix' => 'evento','namespace' => 'Modulos\Eventos'], function()
    {
        Route::group(['prefix' => 'gestion'], function()
        {
            Route::get ('/crear','GestionEventoController@InitCrearEvento');
            Route::post('/crear','GestionEventoController@InitCrearEvento');
            Route::post('/accionEvento','GestionEventoController@InitAccionEvento');

            Route::get ('/registro','GestionEventoController@InitRegistroEvento');
            Route::post('/registro','GestionEventoController@InitRegistroEvento');
        });
    });

    Route::group(['prefix' => 'elecciones','namespace' => 'Modulos\Elecciones'], function()
    {
        Route::group(['prefix' => 'votacion'], function()
        {
            Route::get ('diaconos','VotacionController@InitVotacionDiaconos');
            Route::post('diaconos','VotacionController@InitVotacionDiaconos');

            Route::get ('test','VotacionController@InitTest');
            Route::post('test','VotacionController@InitTest');
        });

        Route::group(['prefix' => 'estadisticas'], function()
        {
            Route::get ('total-diaconos','EstadisticaController@InitResultadosDiaconos');
            Route::get ('resumen','EstadisticaController@InitResumenDiaconos');

            Route::get ('real-time','EstadisticaController@InitRealTime');
        });


    });

});

Route::get('/logout','LoginController@Logout');