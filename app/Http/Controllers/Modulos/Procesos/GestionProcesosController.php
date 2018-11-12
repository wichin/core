<?php namespace App\Http\Controllers\Modulos\Procesos;

use App\Http\Controllers\Modulos\MasterController;
use App\Models\tb_instructor;
use App\Models\tb_modulo_educativo;
use App\Models\tb_proceso;
use Carbon\Carbon;
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

    public function InitAgregarInstructor(Request $request)
    {
        $Instructor = new tb_instructor();
        $ModuloE    = new tb_modulo_educativo();

        $isForm         = true;
        $isTable        = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Instructores';
        $titulo       = 'Agregar Instructor';
        $subtitulo    = '';

        if($request->isMethod('POST'))
        {
            $idPersona  = $request->idPersona;
            $fecha      = $request->fecha;

            if(isset($idPersona)&&isset($fecha)&&$idPersona!=''&&$fecha!='')
            {
                $arrayI = [
                    'id_persona'        => $idPersona,
                    'fecha_inicio'      => $this->InvertDate($fecha),
                    'usuario_creacion'  => $this->idUsuario
                ];

                $result = $Instructor->SetInstructor($arrayI);
                if($result)
                    $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'La transacción se realizó correctamente, el instuctor fue agregado al sistema.','class'=>'success'];
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'La transacción no se completo, los parámetros enviados no son válidos.','class'=>'error'];
            }
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'La transacción no se completo, los parámetros enviados no son válidos.','class'=>'error'];

            Session::flash('mensaje',$info);
            return redirect(url('/procesos/gestion/instructor'));
        }

        $dataInstructor = $Instructor->GetInstructor();
        #dd(json_decode($dataInstructor));
        $html           = isset($dataInstructor)&&count($dataInstructor)>0?$this->TablaInstructores($dataInstructor):$this->MsgHtml('fa fa-exclamation-circle','No se encontraron Instructores...','danger');

        return view('modulos.procesos.gestion.instructor',get_defined_vars());
    }

    public function TablaInstructores($data)
    {
        $html = '<table class="table table-striped jambo_table" id="tblInstructores">';
        $html.= '<thead>';
        $html.= '<tr><th>ACCIONES</th><th>NOMBRE</th><th>MODULOS</th><th>FECHA INICIO</th><th>FECHA FINAL</th><th>ESTADO</th></tr>';
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
            $html.= '<td class="text-nowrap">'.$dt->Persona->nombre.' '.$dt->Persona->apellido.'</td>';
            $html.= '<td class="text-center">';
            $html.= isset($dt->ModuloInstructor[0])?$dt->ModuloInstructor[0]->total:0;
            $html.= '</td>';
            $html.= '<td>'.($dt->fecha_inicio!=''?$this->RevertDate($dt->fecha_inicio):'').'</td>';
            $html.= '<td>'.($dt->fecha_final!=''?$this->RevertDate($dt->fecha_final):'').'</td>';
            $html.= '<td class="text-center">'.$this->LabelHtml(($dt->estado==1?'Activo':'Inactivo'),($dt->estado==1?'primary':'danger')).'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitAccionInstructor(Request $request)
    {
        $id64   = $request->data;
        $estado = $request->stat;

        if(isset($id64)&&isset($estado)&&$id64!=''&&$estado!='')
        {
            $Instructor     = new tb_instructor();
            $idInstructor   = base64_decode($id64);

            $arrayIns = [
                'estado'        => $estado,
                'fecha_final'   => $estado==0?Carbon::now()->format('Y-m-d H:i:s'):''
            ];

            if($Instructor->UpdateInstructor($idInstructor,$arrayIns))
            {
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'Transacción exitosa, el estado del Instructor fue actualizado.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El estado del Instructor fue actualizado.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible actualizar el estado del Instructor.'];
        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos'];

        return json_encode($resp);
    }
}
