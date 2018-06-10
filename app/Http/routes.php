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

        });

        Route::group(['prefix' => 'usuario'], function()
        {
            Route::get ('/listar','UsuarioController@InitListar');
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
            Route::get ('resumen-diaconos','EstadisticaController@InitResumenDiaconos');

            Route::get ('real-time','EstadisticaController@InitRealTime');
        });


    });

});

Route::get('/logout','LoginController@Logout');