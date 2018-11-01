<?php namespace App\Http\Controllers\Modulos\Administracion;

use App\Http\Controllers\Modulos\MasterController;

use App\Models\tb_modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UsuarioController extends MasterController
{
    public function InitGestion(Request $request)
    {

    }

    public function InitListar(Request $request)
    {
        #$this->InitPermisos();
        $usuario      = $this->usuario;
        $tituloPagina = 'Usuario';
        $titulo       = 'Usuarios';
        $subtitulo    = '';

        $dataUsuario = $this->ObtenerUsuarios([]);
        $htmlUsuario = isset($dataUsuario)&&count($dataUsuario)>0?$this->TablaUsuarios($dataUsuario):$this->MsgHtml('fa-exclamation-triangle','No se encontro información','danger');

        return view('modulos.administracion.usuario.listar_usuario',get_defined_vars());
    }

    public function ObtenerUsuarios($data)
    {
        return DB::table('tb_usuario as u')
            ->join('tb_persona as p','p.id','=','u.id_persona')
            ->join ('cat_rol as r','r.id','=','u.id_rol')
            ->select('u.id','p.nombre','p.apellido','u.email','r.descripcion as nom_rol','u.estado')
            ->get();
    }

    public function TablaUsuarios($data)
    {
        $html = '<table id="tblUsuarios" class="table jambo_table table-striped table-bordered nowrap" role="grid" width="100%">';
        $html.= '<thead><tr><th>ACCIONES</th><th>NOMBRES</th><th>CORREO</th><th>PERFIL</th><th>ESTADO</th></tr></thead>';
        $html.= '<tbody>';
        foreach ($data as $dt)
        {
            $id64 = base64_encode($dt->id);
            $btnA = $this->BtnHtml('accion(\''.$id64.'\',1)','Activar usuario','toggle-off');
            $btnI = $this->BtnHtml('accion(\''.$id64.'\',0)','Inactivar usuario','toggle-on');


            $html.= '<tr>';
            #ACCIONES
            $html.= '<td class="text-center">';
            $html.= $this->BtnHtml('permisos(\''.$id64.'\')','Permisos','key');
            $html.= '&nbsp;&nbsp;&nbsp;&nbsp;'.(($dt->estado==1) ? $btnI : $btnA);
            $html.= '</td>';

            $html.= '<td>'.$dt->nombre.' '.$dt->apellido.'</td>';
            $html.= '<td>'.$dt->email.'</td>';
            $html.= '<td>'.$dt->nom_rol.'</td>';
            $html.= '<td class="text-center">'.$this->LabelHtml(($dt->estado==1?'Activo':'Inactivo'),$dt->estado==1?'primary':'danger').'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitAccion(Request $request)
    {
        $id64 = $request->data;
        if(isset($id64)&&$id64!='')
        {
            $idUsuario = base64_decode($id64);
            $newEstado = $request->accion;

            $update = DB::table('tb_usuario')
                ->where('id',$idUsuario)
                ->update(['estado'=>$newEstado]);

            if($update)
            {
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'La transacción se realizó correctamente, el estado del usuario fue actualizado.','class'=>'success'];
                Session::flash('mensaje',$info);
                $response = ['status'=>'OK','msg'=>'La transacción se realizó correctamente, el estado del usuario fue actualizada.'];
            }
            else
                $response = ['status'=>'ERROR','msg'=>'Los parámetros enviados no son válidos'];
        }
        else
        {
            $response = ['status'=>'ERROR','msg'=>'Los parámetros enviados no son válidos'];
        }

        return json_encode($response);
    }

    public function InitPermisos(Request $request)
    {
        $id64       = $request->data;
        $idUsuario  = base64_decode($id64);

        $Modulo = new tb_modulo();

        $accesos = $this->ObtenerAccesosUsuario($idUsuario,1);

        if(isset($accesos)&&count($accesos)>0)
        {
            foreach ($accesos as $a)
                $arrayAccesos[] = $a->id_aplicacion;
        }
        else
            $arrayAccesos = [];

        $data = $Modulo::with('Menu.Aplicacion')->get();
        $html = (isset($data)&&count($data)>0)?$this->AcordionPermisos($data,$arrayAccesos):$this->MsgHtml('fa-exclamation-triangle','No se encontro información','danger');

        return $html;
    }

    public function AcordionPermisos($data,$accesos)
    {
        $html = '<div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">';
        foreach ($data as $d => $dt)
        {
            if(isset($dt->Menu)&&count($dt->Menu)>0)
            {
                $html.= '<div class="panel">';
                $html.= '<a class="panel-heading" role="tab" id="headingOne'.$d.'" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne'.$d.'" aria-expanded="true" aria-controls="collapseOne">';
                $html.= '<h4 class="panel-title"><i class="'.$dt->icono.' fa-lg"></i>&nbsp;&nbsp;'.$dt->nombre.'</h4>';
                $html.= '</a>';
                $html.= '<div id="collapseOne'.$d.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
                $html.= '<div class="panel-body">';
                $i = 0;
                foreach ($dt->Menu as $menu)
                {
                    if($i>0)
                        $html.='<div class="row"><hr></div>';
                    $html.= '<h4>'.$menu->nombre.'</h4>';
                    $html.= '<div class="row">';
                    foreach ($menu->Aplicacion as $app)
                    {

                        $html.= '<div class="col-md-3 col-sm-6 col-xs-12">';
                        $html.= '<input type="checkbox" class="flat" name="acceso['.$app->id.']" '.(in_array($app->id,$accesos)?'checked':'').'>';
                        $html.= '&nbsp;&nbsp;<label>'.$app->nombre.'</label>';
                        $html.= '</div>';
                    }
                    $html.= '</div>';
                    #$html.= '<div class="row"><hr></div>';
                    $i++;
                }
                $html.= '</div>';
                $html.= '</div>';
                $html.= '</div>';
            }
        }
        $html.= '</div>';

        return $html;
    }

    public function ObtenerAccesosUsuario($idUsuario, $estado = null)
    {
        return DB::table('tb_acceso as a')
            ->join('tb_aplicacion as app','app.id','=','a.id_aplicacion')
            ->join('tb_menu as me','me.id','=','app.id_menu')
            ->join('tb_modulo as mo','mo.id','=','me.id_modulo')
            ->where('a.id_usuario',$idUsuario)
            ->where(function ($sql) use($estado){
                if(isset($estado))
                    $sql->where('a.estado',$estado);
            })
            ->select('a.id_aplicacion')
            ->get();
    }

    public function InitSaveAccess(Request $request)
    {
        $id64       = $request->data;
        $idUsuario  = base64_decode($id64);
        $acceso     = $request->acceso;

        $recibidos  = isset($acceso)?$acceso:[];
        $dataAccesos = $this->ObtenerAccesosUsuario($idUsuario);
        $actuales    = [];

        foreach ($dataAccesos as $ac)
            $actuales[] = $ac->id_aplicacion;

        $nuevos  = [];
        $propios = [];

        foreach ($recibidos as $r => $rec)
        {
            if(in_array($r, $actuales))
                $propios[]  = $r;       #permisos previos para activacion
            else
                $nuevos[]   = $r;       #creación de permisos nuevos activos
        }

        DB::beginTransaction();
        $inactivar = DB::table('tb_acceso')->where('id_usuario',$idUsuario)->update(['estado'=>0]);
        if(isset($inactivar))
        {
            $updatePropios = true;
            if(isset($propios)&&count($propios)>0)
                $updatePropios = DB::table('tb_acceso')->whereIn('id_aplicacion',$propios)->update(['estado'=>1]);

            if($updatePropios)
            {
                $insertNuevos = true;
                if(isset($nuevos)&&count($nuevos)>0)
                {
                    $result = [];
                    foreach ($nuevos as $nue)
                    {
                        $result[] = DB::table('tb_acceso')->insert(['id_usuario'=>$idUsuario,'id_aplicacion'=> $nue]);
                    }

                    $insertNuevos = !in_array(0,$result);
                }

                if($insertNuevos)
                {
                    DB::commit();
                    $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'Los accesos fueron actualizados correctamente.','class'=>'info'];
                    Session::flash('mensaje',$info);
                    $resp = ['estado'=>'OK','mensaje'=>'Los accesos fueron actualizados correctamente'];
                }
                else
                {
                    DB::rollback();
                    $resp = ['estado'=>'ERROR','mensaje'=>'No fue posible crear los nuevos accesos del usuario'];
                }
            }
            else
            {
                DB::rollback();
                $resp = ['estado'=>'ERROR','mensaje'=>'No fue posible activar los accesos del usuario'];
            }
        }
        else
        {
            DB::rollback();
            $resp = ['estado'=>'ERROR','mensaje'=>'No fue posible verificar los accesos del usuario'];
        }

        return json_encode($resp);
    }
}
