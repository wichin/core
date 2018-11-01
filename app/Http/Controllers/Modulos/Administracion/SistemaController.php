<?php namespace App\Http\Controllers\Modulos\Administracion;

use App\Http\Controllers\Modulos\MasterController;

use App\Models\tb_modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SistemaController extends MasterController
{
    public function InitModulo(Request $request)
    {
        $usuario      = $this->usuario;
        $tituloPagina = 'Módulo de sistema';
        $titulo       = 'Módulo de sistema';
        $subtitulo    = '';

        return view('modulos.administracion.sistema.modulo',get_defined_vars());
    }
}
