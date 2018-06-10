<?php namespace App\Http\Controllers\Modulos\Administracion;

use App\Http\Controllers\Modulos\MasterController;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends MasterController
{
    public function InitGestion(Request $request)
    {

    }

    public function InitListar(Request $request)
    {
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
            ->select('p.nombre','p.apellido','u.email','r.descripcion as nom_rol','u.estado')
            ->get();
    }

    public function TablaUsuarios($data)
    {
        $html = '<table class="table table-responsive table-striped table-bordered">';
        $html.= '<thead><tr><th>NOMBRES</th><th>CORREO</th><th>PERFIL</th><th>ESTADO</th></tr></thead>';
        $html.= '<tbody>';
        foreach ($data as $dt)
        {
            $html.= '<tr>';
            $html.= '<td>'.$dt->nombre.' '.$dt->apellido.'</td>';
            $html.= '<td>'.$dt->email.'</td>';
            $html.= '<td>'.$dt->nom_rol.'</td>';
            $html.= '<td>'.($dt->estado==1?'Activo':'Inactivo').'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }
}
