<?php namespace App\Http\Controllers\Modulos\Procesos;

use App\Http\Controllers\Modulos\MasterController;
use App\Models\tb_proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GestionProcesosController extends MasterController
{
    public function InitCrearProceso(Request $request)
    {
        $Proceso = new tb_proceso();

        $isForm         = true;
        $isTable        = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Procesos';
        $titulo       = 'Crear proceso';
        $subtitulo    = '';

        if($request->isMethod('POST'))
        {
            $nombre         = $request->nombre;
            $descripcion    = $request->descripcion;

            $validaNombre   = $Proceso->ValidaNombre($nombre);
            #dd($request->all(),$validaNombre);

            if(isset($validaNombre))
            {
                if(count($validaNombre)==0)
                {
                    $arrayEvento = ['nombre'=>$nombre,'descripcion'=>$descripcion,'usuario_creacion'=>$this->idUsuario];
                    if($Proceso->SetProceso($arrayEvento))
                        $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Proceso '.$nombre.' fue almacenado correctamente.','class'=>'info'];
                    else
                        $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible registrar el nuevo Proceso.','class'=>'error'];
                }
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'El nombre '.$nombre.' ya se encuentra registrado como Proceso.','class'=>'error'];
            }
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible validar el nombre del Proceso.','class'=>'error'];

            Session::flash('mensaje',$info);
            return redirect(url('/procesos/gestion/crear'));
        }

        $dataProceso = $Proceso->GetProcesos();
        #dd($dataProceso);
        $html       = isset($dataProceso)&&count($dataProceso)>0?$this->TablaProcesos($dataProceso):$this->MsgHtml('fa fa-exclamation-circle','No se encontraron Procesos...','danger');

        return view('modulos.procesos.gestion.crearproceso',get_defined_vars());
    }

    public function TablaProcesos($data)
    {
        $html = '<table class="table table-striped jambo_table" id="tblProcesos">';
        $html.= '<thead>';
        $html.= '<tr><th>ACCIONES</th><th>NOMBRE</th><th>DESCRIPCION</th><th>MODULOS</th><th>ESTADO</th></tr>';
        $html.= '</thead>';
        $html.= '<tbody>';
        foreach ($data as $dt)
        {
            $id64 = base64_encode($dt->id);
            $html.= '<tr>';
            $html.= '<td class="text-center text-nowrap">';
            $html.= $this->BtnHtml('accion(\''.$id64.'\','.($dt->estado==1?0:1).')',($dt->estado==1?'Inactivar':'Activar'),($dt->estado==1?'toggle-on':'toggle-off'));
            $html.= '&nbsp;&nbsp;&nbsp;&nbsp'.$this->BtnHtml('editar()','Editar Módulo','pencil-square-o');
            $html.= '</td>';
            $html.= '<td class="text-nowrap">'.$dt->nombre.'</td>';
            $html.= '<td>'.$dt->descripcion.'</td>';
            $html.= '<td class="text-center">';
            $html.= isset($dt->ModuloEducativo[0])?$dt->ModuloEducativo[0]->total:0;
            $html.= '</td>';
            $html.= '<td class="text-center">'.$this->LabelHtml(($dt->estado==1?'Activo':'Inactivo'),($dt->estado==1?'primary':'danger')).'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitAccionProceso(Request $request)
    {
        $id64   = $request->data;
        $estado = $request->stat;

        if(isset($id64)&&isset($estado)&&$id64!=''&&$estado!='')
        {
            $Proceso    = new tb_proceso();
            $idProceso  = base64_decode($id64);

            if($Proceso->UpdateProceso($idProceso,['estado'=>$estado]))
            {
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'Transacción exitosa, el Proceso fue actualizado.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Proceso fue actualizado.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible actualizar el estado del Proceso.'];
        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos'];

        return json_encode($resp);
    }
}
