<?php namespace App\Http\Controllers\Modulos\Miembros;

use App\Http\Controllers\Modulos\MasterController;

use App\Models\tb_persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GestionController extends MasterController
{
    public function InitAgregar(Request $request)
    {
        $usuario        = $this->usuario;
        $tituloPagina   = 'Miembros';
        $titulo         = 'Agregar';
        $subtitulo      = 'Miembros';
        $isForm         = true;

        if($request->isMethod('POST'))
        {
            $Persona = new tb_persona();
            $type = base64_decode($request->apps);
            if($type==1)
            {
                $insertData = $request->data;
                $insertData['url_foto'] = $request->miPick;
                $insertData['fecha_nacimiento'] = $request->fecha_nacimiento!=''?$this->InvertDate($request->fecha_nacimiento):'';
                $result = $Persona->InsertGetId($insertData);
                if($result)
                    $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'La transacción se realizó correctamente, la persona fue agregada al sistema.','class'=>'success'];
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'La transacción no se completo, la persona no fue agregada al sistema','class'=>'error'];

                Session::flash('mensaje',$info);
                return redirect(url('/miembros/gestion/agregar'));
            }
            else if ($type==2)
            {
                $idPersona = base64_decode($request->code);
                $dataPersona = $Persona->GetFullData($idPersona);
                if(isset($dataPersona)&&count($dataPersona)>0)
                {
                    $apps = base64_encode(3);
                    $dt = $dataPersona[0];
                    $nacimiento = isset($dt->fecha_nacimiento)&&$dt->fecha_nacimiento!=''?$this->RevertDate($dt->fecha_nacimiento):'';
                    #dd($dt, $nacimiento);
                }
                else
                {
                    $info = ['titulo'=>'ERROR EN CONSULTA','msg'=>'No fue posible encontrar la información solicitada.','class'=>'error'];
                    Session::flash('mensaje',$info);
                    return redirect(url('/miembros/gestion/listar'));
                }
            }
            else if($type==3)
            {
                #dd($request->all());
                $idPersona  = base64_decode($request->code);
                $dataUpdate = $request->data;

                $dataUpdate['fecha_nacimiento'] = $request->fecha_nacimiento!=''?$this->InvertDate($request->fecha_nacimiento):'';
                if($request->miPick!='')
                    $dataUpdate['url_foto'] = $request->miPick;

                $result = $Persona->UpdateById($idPersona, $dataUpdate);
                #dd($result, $idPersona,$request->all());

                if($result)
                    $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'La transacción se realizó correctamente, la información de la persona fue actualizada.','class'=>'success'];
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'La transacción no se completo, la información de la persona no fue actualizada.','class'=>'error'];

                Session::flash('mensaje',$info);
                return redirect(url('/miembros/gestion/listar'));

            }
        }

        $catSexo = $this->GetCatalogo('cat_sexo',1);
        $catGrupo = $this->GetCatalogo('cat_grupo',1);

        return view('modulos.miembros.gestion.agregar',get_defined_vars());
    }

    public function InitListar(Request $request)
    {
        $usuario        = $this->usuario;
        $tituloPagina   = 'Miembros';
        $titulo         = 'Listado';
        $subtitulo      = 'Miembros';
        $isTable        = true;

        $Persona        = new tb_persona();

        $dataPersona    = $Persona->GetFullData();
        $htmlPersona    = isset($dataPersona)&&count($dataPersona)>0?$this->TablaPersona($dataPersona):$this->MsgHtml('fa-exclamation-triangle','No se encontro información','danger');

        #dd($dataPersona);

        return view('modulos.miembros.gestion.listar',get_defined_vars());
    }

    public function TablaPersona($data)
    {
        #dd(json_decode($data));
        $html = '<table id="tblPersona" class="table jambo_table table-striped table-bordered nowrap" role="grid" width="100%">';
        $html.= '<thead><tr><th>ACCIONES</th><th>DETALLE</th><th>NOMBRES</th><th>APELLIDOS</th><th>FECHA NACIMIENTO</th><th>CUI</th><th>SEXO</th><th>GRUPO</th><th>ESTADO</th></tr></thead>';
        $html.= '<tbody>';
        foreach ($data as $dt)
        {
            $id64 = base64_encode($dt->id);
            $btnA = $this->BtnHtml('accion(\''.$id64.'\',1)','Activar persona','toggle-off');
            $btnI = $this->BtnHtml('accion(\''.$id64.'\',0)','Inactivar persona','toggle-on');


            $html.= '<tr>';
            #ACCIONES
            $html.= '<td class="text-center">';
            #$html.= $this->BtnHtml('permisos(\''.$id64.'\')','Permisos','key');
            $html.= (($dt->estado==1) ? $btnI : $btnA);
            $html.= '&nbsp;'.$this->BtnHtml('actualizar(\''.$id64.'\',\''.$dt->nombre.'\')','Actualizar Información','refresh');
            $html.= '&nbsp;'.$this->BtnHtml('ministerio(\''.$id64.'\')','Agregar Ministerio','home');
            $html.= '&nbsp;'.$this->BtnHtml('proceso(\''.$id64.'\')','Agregar Proceso','cog');
            $html.= '&nbsp;'.$this->BtnHtml('evento(\''.$id64.'\')','Agregar Evento','calendar-o');
            $html.= '</td>';
            $html.= '<td class="text-center">';
            $html.= $this->BtnHtml('detalle(\''.$id64.'\')','Información Personal','list-ul');
            $html.= '</td>';
            $nombre = $dt->url_foto!=''?$dt->nombre.'*':$dt->nombre;
            $html.= '<td>'.$nombre.'</td>';
            $html.= '<td>'.$dt->apellido.'</td>';
            $html.= '<td>'.$dt->fecha_nacimiento.'</td>';
            $html.= '<td>'.$dt->cui.'</td>';
            $html.= '<td>'.$dt->Sexo->descripcion.'</td>';
            $html.= '<td>'.$dt->Grupo->descripcion.'</td>';
            $html.= '<td class="text-center">'.$this->LabelHtml(($dt->estado==1?'Activo':'Inactivo'),$dt->estado==1?'primary':'danger').'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitBuscarPersona(Request $request)
    {
        $sugerencias = [];

        $data   = $request->all();
        $query  = $data['query'];

        $Persona = new tb_persona();
        $dataPersona = $Persona->GetPersonaByNombre($query);

        if(isset($dataPersona)&&count($dataPersona)>0)
        {
            foreach ($dataPersona as $da)
            {
                $sugerencias[] = array(
                    'value' => $da->nombre.' '.$da->apellido,
                    'data'  => $da->id
                );
            }
        }

        return json_encode(array(
            'query'         => $query,
            'suggestions'   => $sugerencias
        ));
    }
}
