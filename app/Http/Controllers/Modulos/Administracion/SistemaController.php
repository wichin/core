<?php namespace App\Http\Controllers\Modulos\Administracion;

use App\Http\Controllers\Modulos\MasterController;

use App\Models\tb_aplicacion;
use App\Models\tb_menu;
use App\Models\tb_modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SistemaController extends MasterController
{
    public function InitModulo(Request $request)
    {
        $Modulo     = new tb_modulo();

        $isForm         = true;
        $isTable        = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Módulo de sistema';
        $titulo       = 'Módulo de sistema';
        $subtitulo    = '';

        if($request->isMethod('POST'))
        {
            $nombreModulo = $request->nombre;
            $validaNombre = $Modulo->ValidaNombre($nombreModulo);
            if(isset($validaNombre))
            {
                if(count($validaNombre)==0)
                {
                    $arrayModulo = ['nombre'=>$nombreModulo,'icono'=>$request->icono];
                    if($Modulo->SetModulo($arrayModulo))
                        $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Módulo '.$nombreModulo.' fue almacenado correctamente.','class'=>'info'];
                    else
                        $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible registrar el nuevo Módulo.','class'=>'error'];
                }
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'El nombre '.$nombreModulo.' ya se encuentra registrado como Módulo.','class'=>'error'];
            }
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible validar el nombre del Módulo.','class'=>'error'];

            Session::flash('mensaje',$info);
            return redirect(url('/admin/sistema/modulo'));
        }

        $dataModulo = $Modulo->GetModulos();
        $html       = isset($dataModulo)&&count($dataModulo)>0?$this->TablaModulos($dataModulo):$this->MsgHtml('fa fa-exclamation-circle','No se encontraron Módulos...','danger');

        return view('modulos.administracion.sistema.modulo',get_defined_vars());
    }

    public function TablaModulos($data)
    {
        $html = '<table class="table table-striped jambo_table" id="tblModulos">';
        $html.= '<thead>';
        $html.= '<tr><th>ACCIONES</th><th>NOMBRE</th><th>ICONO</th><th>ESTADO</th></tr>';
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
            $html.= '<td>'.$dt->nombre.'</td>';
            $html.= '<td class="text-center"><i class="'.$dt->icono.' fa-2x"></i></td>';
            $html.= '<td class="text-center">'.$this->LabelHtml(($dt->estado==1?'Activo':'Inactivo'),($dt->estado==1?'primary':'danger')).'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitAccionModulo(Request $request)
    {
        $id64   = $request->data;
        $estado = $request->stat;

        if(isset($id64)&&isset($estado)&&$id64!=''&&$estado!='')
        {
            $Modulo     = new tb_modulo();
            $idModulo   = base64_decode($id64);

            if($Modulo->UpdateModulo($idModulo,['estado'=>$estado]))
            {
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'Transacción exitosa, el módulo fue actualizado.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Módulo fue actualizado.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
            {
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible actualizar el estado del Módulo.'];
            }
        }
        else
        {
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos'];
        }

        return json_encode($resp);
    }

    public function InitMenu(Request $request)
    {
        $Modulo = new tb_modulo();
        $Menu   = new tb_menu();

        $isForm     = true;
        $isTable    = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Menú de sistema';
        $titulo       = 'Menú de sistema';
        $subtitulo    = '';

        $catModulo  = $Modulo->GetModulos(1);
        $dataMenu   = $Menu->GetMenu();

        if($request->isMethod('POST'))
        {
            $idModulo   = $request->modulo;
            $nombreMenu = $request->nombre;

            $validaNombre = $Menu->ValidaNombre($nombreMenu,$idModulo);

            if(isset($validaNombre))
            {
                if(count($validaNombre)==0)
                {
                    $arrayMenu = ['nombre'=>$nombreMenu,'id_modulo'=>$idModulo];
                    if($Menu->SetMenu($arrayMenu))
                        $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Menú '.$nombreMenu.' fue almacenado correctamente.','class'=>'info'];
                    else
                        $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible registrar el nuevo Menú.','class'=>'error'];
                }
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'El nombre '.$nombreMenu.' ya se encuentra registrado como Menú.','class'=>'error'];
            }
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible validar el nombre del Módulo.','class'=>'error'];

            Session::flash('mensaje',$info);
            return redirect(url('/admin/sistema/menu'));
        }

        $html = isset($dataMenu)&&count($dataMenu)>0?$this->TablaMenu($dataMenu):$this->MsgHtml('fa fa-exclamation-circle','No se encontraron Menús...','danger');

        return view('modulos.administracion.sistema.menu',get_defined_vars());
    }

    public function TablaMenu($data)
    {
        $html = '<table class="table table-striped jambo_table" id="tblMenus">';
        $html.= '<thead>';
        $html.= '<tr><th>ACCIONES</th><th>MÓDULO</th><th>MENÚ</th><th>ESTADO</th></tr>';
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
            $html.= '<td>'.$dt->Modulo->nombre.'</td>';
            $html.= '<td>'.$dt->nombre.'</td>';
            $html.= '<td class="text-center">'.$this->LabelHtml(($dt->estado==1?'Activo':'Inactivo'),($dt->estado==1?'primary':'danger')).'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitAccionMenu(Request $request)
    {
        $id64   = $request->data;
        $estado = $request->stat;

        if(isset($id64)&&isset($estado)&&$id64!=''&&$estado!='')
        {
            $Menu   = new tb_menu();
            $idMenu = base64_decode($id64);

            if($Menu->UpdateMenu($idMenu,['estado'=>$estado]))
            {
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'Transacción exitosa, el menú fue actualizado.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Menú fue actualizado.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
            {
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible actualizar el estado del Menú.'];
            }
        }
        else
        {
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos'];
        }

        return json_encode($resp);
    }

    public function InitAplicacion(Request $request)
    {
        $Modulo = new tb_modulo();
        $App    = new tb_aplicacion();

        $isForm     = true;
        $isTable    = true;

        $usuario      = $this->usuario;
        $tituloPagina = 'Aplicativo de sistema';
        $titulo       = 'Aplicativo de sistema';
        $subtitulo    = '';

        if($request->isMethod('POST'))
        {
            $idModulo   = $request->modulo;
            $idMenu     = $request->menu;
            $nombre     = $request->nombre;
            $url        = $request->url;

            $validaNombre = $App->ValidaNombre($nombre,$idMenu);

            if(isset($validaNombre))
            {
                if(count($validaNombre)==0)
                {
                    $arrayAplicacion = ['nombre'=>$nombre,'url'=>$url,'id_menu'=>$idMenu];
                    if($App->SetAplicacion($arrayAplicacion))
                        $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Menú '.$nombre.' fue almacenado correctamente.','class'=>'info'];
                    else
                        $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible registrar el nuevo Menú.','class'=>'error'];
                }
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'El nombre '.$nombre.' ya se encuentra registrado como Menú.','class'=>'error'];
            }
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible validar el nombre del Módulo.','class'=>'error'];

            Session::flash('mensaje',$info);
            return redirect(url('/admin/sistema/aplicacion'));
        }

        $catModulo  = $Modulo->GetModulos(1);
        $dataApp    = $App->GetAplicacion();

        $html = isset($dataApp)&&count($dataApp)>0?$this->TablaAplicacion($dataApp):$this->MsgHtml('fa fa-exclamation-circle','No se encontraron Aplicaciones...','danger');

        return view('modulos.administracion.sistema.aplicacion',get_defined_vars());
    }

    public function TablaAplicacion($data)
    {
        $html = '<table class="table table-striped jambo_table" id="tblAplicacion">';
        $html.= '<thead>';
        $html.= '<tr><th>ACCIONES</th><th>APLICACIÓN</th><th>URL</th><th>MENÚ</th><th>MÓDULO</th><th>ESTADO</th></tr>';
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
            $html.= '<td>'.$dt->nombre.'</td>';
            $html.= '<td>'.$dt->url.'</td>';
            $html.= '<td>'.$dt->Menu->nombre.'</td>';
            $html.= '<td>'.$dt->Menu->Modulo->nombre.'</td>';
            $html.= '<td class="text-center">'.$this->LabelHtml(($dt->estado==1?'Activo':'Inactivo'),($dt->estado==1?'primary':'danger')).'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitBuscarMenu(Request $request)
    {
        $Menu       = new tb_menu();
        $idModulo   = $request->data;

        $dataMenu   = $Menu->GetMenuByModulo($idModulo);
        if(isset($dataMenu)&&count($dataMenu)>0)
        {
            $select = '<option value="" style="display: none" selected>Seleccione...</option>';
            foreach ($dataMenu as $dm)
            {
                $select.= '<option value="'.$dm->id.'">'.$dm->nombre.'</option>';
            }

            $resp = ['ESTADO'=>'OK','DATA'=>$select];
        }
        else
        {
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No se encontraron Menús disponibles.'];
        }

        return json_encode($resp);
    }
}
