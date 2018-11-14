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
            Route::get ('/busquedaInstructor','GestionController@InitBusquedaInstructor');

            Route::get ('/estadisticas','GestionController@InitEstadisticas');
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

    Route::group(['prefix' => 'procesos','namespace' => 'Modulos\Procesos'], function()
    {
        Route::group(['prefix' => 'gestion'], function()
        {
            Route::get ('/crear','GestionProcesosController@InitCrearProceso');
            Route::post('/crear','GestionProcesosController@InitCrearProceso');
            Route::post('/accionProceso','GestionProcesosController@InitAccionProceso');

            Route::get ('/instructor','GestionProcesosController@InitAgregarInstructor');
            Route::post('/instructor','GestionProcesosController@InitAgregarInstructor');
            Route::post('/accionInstructor','GestionProcesosController@InitAccionInstructor');
        });

        Route::group(['prefix' => 'modulos'], function()
        {
            Route::get ('/crear','ModuloEducativoController@InitCrearModulo');
            Route::post('/crear','ModuloEducativoController@InitCrearModulo');
            Route::post('/accionModulo','GestionProcesosController@InitAccionProceso');

            Route::get ('/listar','ModuloEducativoController@InitListarModulo');
            Route::post('/listar','ModuloEducativoController@InitListarModulo');
            Route::post('/estado','ModuloEducativoController@InitEstadoModulo');

            Route::post('/buscarInstructores','ModuloEducativoController@InitBuscarInstructores');
            Route::post('/agregarInstructores','ModuloEducativoController@InitAgregarInstructores');

            Route::get ('/alumnos','ModuloEducativoController@InitListarAlumno');
            Route::post('/alumnos','ModuloEducativoController@InitListarAlumno');
            Route::post('/buscarModulo','ModuloEducativoController@InitBuscarModulo');
            Route::post('/agregarAlumno','ModuloEducativoController@InitAgregarAlumno');
            Route::post('/estadoAlumno','ModuloEducativoController@InitEstadoAlumno');
            Route::post('/calificacion','ModuloEducativoController@InitCalificacion');
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