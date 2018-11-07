<?php namespace App\Http\Controllers\Modulos\Procesos;

use App\Http\Controllers\Modulos\MasterController;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\tb_modulo_educativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ModuloEducativoController extends MasterController
{
    public function InitCrearModulo(Request $request)
    {
        $ModuloE = new tb_modulo_educativo();

        $isForm         = true;
        #$isTable        = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Módulo Educativo';
        $titulo       = 'Crear módulo educativo';
        $subtitulo    = '';

        if($request->isMethod('POST'))
        {
            $arrayModulo = [
                'nombre'            => $request->nombre,
                'id_proceso'        => $request->proceso,
                'id_tipo_reunion'   => $request->tipo,
                'fecha_inicio'      => $request->inicio!=''?$this->InvertDate($request->inicio):'',
                'fecha_final'       => $request->final!=''?$this->InvertDate($request->final):'',
                'observaciones'     => $request->observaciones,
                'usuario_creacion'  => $this->idUsuario
            ];

            if($ModuloE->SetModuloEducativo($arrayModulo))
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Módulo Educativo '.$request->nombre.' fue almacenado correctamente.','class'=>'info'];
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible registrar el nuevo Módulo educativo.','class'=>'error'];

            Session::flash('mensaje',$info);
            return redirect(url('/procesos/modulos/crear'));
        }

        $procesos = $this->GetCatalogo('tb_proceso',1);
        $catTipo  = $this->GetCatalogo('cat_tipo_reunion',1);

        return view('modulos.procesos.modulos.crearmodulo',get_defined_vars());
    }

    public function InitListarModulo(Request $request)
    {
        $ModuloE = new tb_modulo_educativo();

        $isForm         = true;
        $isTable        = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Módulo Educativo';
        $titulo       = 'Listar módulos educativos';
        $subtitulo    = '';

        $procesos   = $this->GetCatalogo('tb_proceso');
        $estadoMod  = $this->GetCatalogo('cat_estado_modulo');

        return view('modulos.procesos.modulos.listarmodulo',get_defined_vars());
    }
}
