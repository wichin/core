<?php namespace App\Http\Controllers\Modulos\Eventos;

use App\Http\Controllers\Modulos\MasterController;

use App\Models\tb_evento;
use App\Models\tb_persona_evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpSpec\Loader\Transformer\TypeHintIndex;

class GestionEventoController extends MasterController
{
    public function InitCrearEvento(Request $request)
    {
        $Evento = new tb_evento();

        $isForm         = true;
        $isTable        = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Eventos';
        $titulo       = 'Crear evento';
        $subtitulo    = '';


        if($request->isMethod('POST'))
        {
            $nombre         = $request->nombre;
            $descripcion    = $request->descripcion;

            $validaNombre   = $Evento->ValidaNombre($nombre);
            #dd($request->all(),$validaNombre);

            if(isset($validaNombre))
            {
                if(count($validaNombre)==0)
                {
                    $arrayEvento = ['nombre'=>$nombre,'descripcion'=>$descripcion,'usuario_creacion'=>$this->idUsuario];
                    if($Evento->SetEvento($arrayEvento))
                        $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Evento '.$nombre.' fue almacenado correctamente.','class'=>'info'];
                    else
                        $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible registrar el nuevo Evento.','class'=>'error'];
                }
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'El nombre '.$nombre.' ya se encuentra registrado como Evento.','class'=>'error'];
            }
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible validar el nombre del Evento.','class'=>'error'];

            Session::flash('mensaje',$info);
            return redirect(url('/evento/gestion/crear'));
        }

        $dataEvento = $Evento->GetEvento();
        #dd(json_decode($dataEvento));
        $html       = isset($dataEvento)&&count($dataEvento)>0?$this->TablaEventos($dataEvento):$this->MsgHtml('fa fa-exclamation-circle','No se encontraron Eventos...','danger');

        return view('modulos.eventos.gestion.crearevento',get_defined_vars());
    }

    public function TablaEventos($data)
    {
        $html = '<table class="table table-striped jambo_table" id="tblEventos">';
        $html.= '<thead>';
        $html.= '<tr><th>ACCIONES</th><th>NOMBRE</th><th>DESCRIPCION</th><th>REGISTROS</th><th>ESTADO</th></tr>';
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
            $html.= isset($dt->PersonaEvento[0])?$dt->PersonaEvento[0]->total:0;
            $html.= '</td>';
            $html.= '<td class="text-center">'.$this->LabelHtml(($dt->estado==1?'Activo':'Inactivo'),($dt->estado==1?'primary':'danger')).'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitAccionEvento(Request $request)
    {
        $id64   = $request->data;
        $estado = $request->stat;

        if(isset($id64)&&isset($estado)&&$id64!=''&&$estado!='')
        {
            $Evento     = new tb_evento();
            $idEvento   = base64_decode($id64);

            if($Evento->UpdateEvento($idEvento,['estado'=>$estado]))
            {
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'Transacción exitosa, el Evento fue actualizado.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Evento fue actualizado.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible actualizar el estado del Evento.'];
        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos'];

        return json_encode($resp);
    }

    public function InitRegistroEvento(Request $request)
    {
        $isForm = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Eventos';
        $titulo       = 'Registro de eventos';
        $subtitulo    = '';

        if($request->isMethod('POST'))
        {
            $idPersona  = $request->idPersona;
            $idEvento   = $request->evento;
            $fecha      = $request->fecha;
            $obs        = $request->observaciones;

            $Evento = new tb_persona_evento();

            $validaEvento = $Evento->ValidaEvento($idPersona, $idEvento);
            if(isset($validaEvento))
            {
                if(count($validaEvento)==0)
                {
                    $arrayEvento = [
                        'id_persona'        => $idPersona,
                        'id_evento'         => $idEvento,
                        'fecha'             => $this->InvertDate($fecha),
                        'observaciones'     => $obs,
                        'usuario_creacion'  => $this->idUsuario
                    ];

                    if($Evento->SetEventoPersona($arrayEvento))
                        $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Evento fue registrado para el Miembro correctamente.','class'=>'info'];
                    else
                        $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible registrar el Evento para el Miembro.','class'=>'error'];
                }
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'El Evento ya se encuentra registrado para el Miembro seleccionado.','class'=>'error'];
            }
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible validar el evento.','class'=>'error'];

            Session::flash('mensaje',$info);
            return redirect(url('/evento/gestion/registro'));
        }

        $listEvento   = $this->GetCatalogo('tb_evento',1);

        return view('modulos.eventos.gestion.registroevento',get_defined_vars());
    }
}
