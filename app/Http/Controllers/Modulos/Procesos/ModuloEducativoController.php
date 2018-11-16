<?php namespace App\Http\Controllers\Modulos\Procesos;

use App\Http\Controllers\Modulos\MasterController;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\tb_modulo_alumno;
use App\Models\tb_modulo_educativo;
use App\Models\tb_modulo_instructor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        if($request->isMethod('POST'))
        {
            $proceso    = $request->proceso;
            $estado     = $request->estado;
            $dataModulo = $ModuloE->FindModulo($proceso,$estado);
            #dd(json_decode($dataModulo));

            $html = isset($dataModulo)&&count($dataModulo)>0?$this->TablaModulos($dataModulo):$this->MsgHtml('fa fa-exclamation-circle','No se encontraron Módulos, la busqueda no registra coincidencias...','danger');
        }

        $procesos   = $this->GetCatalogo('tb_proceso');
        $estadoMod  = $this->GetCatalogo('cat_estado_modulo');

        return view('modulos.procesos.modulos.listarmodulo',get_defined_vars());
    }

    public function TablaModulos($data)
    {
        $html = '<table class="table table-striped jambo_table" id="tblProcesos">';
        $html.= '<thead>';
        $html.= '<tr><th>ACCIONES</th><th>PROCESO</th><th>NOMBRE</th><th>INICIO</th><th>FINAL</th><th>MODALIDAD</th><th>ESTADO</th></tr>';
        $html.= '</thead>';
        $html.= '<tbody>';
        foreach ($data as $dt)
        {
            $id64 = base64_encode($dt->id);
            $nm64 = base64_encode($dt->nombre);
            $stat = $dt->id_estado;
            $html.= '<tr>';
            $html.= '<td class="text-center text-nowrap">';
            if($stat==1)
            {
                $html.= $this->BtnHtml('instructor(\''.$id64.'\',\''.$nm64.'\')','Asignar Instructor','user').'&nbsp;&nbsp;&nbsp;&nbsp;';
                $html.= $this->BtnHtml('finaliza(\''.$id64.'\',3,\'FINALIZAR\')','Finalizar Módulo','check-square').'&nbsp;&nbsp;&nbsp;&nbsp;';
                $html.= $this->BtnHtml('accion(\''.$id64.'\',2,\'SUSPENDER\')','Suspender Módulo','clock-o').'&nbsp;&nbsp;&nbsp;&nbsp;';
                $html.= $this->BtnHtml('accion(\''.$id64.'\',4,\'ANULAR\')','Anular Módulo','trash');
            }
            else if ($stat == 2)
                $html.= $this->BtnHtml('accion(\''.$id64.'\',1,\'ACTIVAR\')','Activar Módulo','power-off');
            else
                $html.= $this->BtnHtml(null,'No disponible','ban');

            $html.= '</td>';
            $html.= '<td>'.$dt->Proceso->nombre.'</td>';
            $html.= '<td class="text-nowrap">'.$dt->nombre.'</td>';
            $html.= '<td class="text-center">'.$dt->fecha_inicio.'</td>';
            $html.= '<td class="text-center">'.$dt->fecha_final.'</td>';
            $html.= '<td class="text-center">'.$dt->TipoReunion->descripcion.'</td>';
            $html.= '<td class="text-center">'.$dt->Estado->descripcion.'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitEstadoModulo(Request $request)
    {
        $id64 = $request->data;
        $stat = $request->stat;

        if(isset($id64)&&isset($stat)&&$id64!=''&&$stat!='')
        {
            $ModuloE    = new tb_modulo_educativo();
            $idModulo   = base64_decode($id64);
            $fecha      = $request->fecha;

            $arrayModulo = [
                'id_estado'             => $stat,
                'usuario_modificacion'  => $this->idUsuario,
                'fecha_modificacion'    => Carbon::now()->format('Y-m-d H:i:s')
            ];

            if($stat==3&&$fecha!='')
                $arrayModulo['fecha_final'] = $this->InvertDate($request->fecha);

            if($ModuloE->UpdateModulo($idModulo, $arrayModulo))
            {
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'El estado del Módulo Educativo fue modificado exitosamente.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El estado del Módulo Educativo fue modificado.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible modificar el estado del Módulo Educativo.'];
        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos'];

        return json_encode($resp);
    }

    public function InitBuscarInstructores(Request $request)
    {
        $id64 = $request->data;

        if(isset($id64)&&$id64!='')
        {
            $ModuloI    = new tb_modulo_instructor();
            $idModulo   = (int)base64_decode($id64);

            $dataInstructores = $ModuloI->GetInstructorDisponible($idModulo);
            if(isset($dataInstructores)&&count($dataInstructores)>0)
            {
                $select = '';
                foreach ($dataInstructores as $di)
                    $select.='<option value="'.$di->id.'">'.$di->nombre.' '.$di->apellido .'</option>';

                $resp = ['ESTADO'=>'OK','MENSAJE'=>$select];
            }
            else
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No se encontraron instructores disponibles para el Módulo seleccionado.'];

        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos'];

        return json_encode($resp);
    }

    public function InitAgregarInstructores(Request $request)
    {
        $id64 = $request->_dataI;
        $inst = $request->instructores;

        if(isset($id64)&&isset($inst)&&$id64!=''&&count($inst)>0)
        {
            $Modulo     = new tb_modulo_instructor();
            $idModulo   = base64_decode($id64);
            $result     = null;

            DB::beginTransaction();

            foreach ($inst as $i)
            {
                $arrayMod = [
                    'id_emodulo'        => $idModulo,
                    'id_instructor'     => $i,
                    'usuario_creacion'  => $this->idUsuario
                ];

                $result[] = $Modulo->InsertMod($arrayMod)?1:0;
            }

            if(!in_array(0,$result))
            {
                DB::commit();
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'Los instructores fueron asignados correctamente.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'Los instructores fueron asignados correctamente.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
            {
                DB::rollback();
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible asignar a los Instructores.'];
            }
        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos.'];

        return json_encode($resp);
    }

    public function InitListarAlumno(Request $request)
    {
        $isForm     = true;
        $isTable    = true;

        $usuario        = $this->usuario;
        $tituloPagina   = 'Alumnos';
        $titulo         = 'Listar alumnos';
        $subtitulo      = '';

        $ModuloE    = new tb_modulo_educativo();
        $catModulo  = $ModuloE->FindModulo('',1);
        $procesos   = $this->GetCatalogo('tb_proceso');

        if($request->isMethod('POST'))
        {
            $ModuloA = new tb_modulo_alumno();

            $idProceso  = $request->proceso;
            $idModulo   = $request->modulo;
            $moduloFind = $ModuloE->FindModulo($idProceso,'');

            $dataAlumnos = $ModuloA->GetByModulo($idModulo);

            $html = isset($dataAlumnos)&&count($dataAlumnos)>0?$this->TablaAlumnos($dataAlumnos):$this->MsgHtml('fa fa-exclamation-circle','No se encontraron Alumnos, la busqueda no registra coincidencias...','danger');
        }

        return view('modulos.procesos.modulos.listaralumnos',get_defined_vars());
    }

    public function TablaAlumnos($data)
    {
        #dd(json_decode($data));
        $html = '<table class="table table-striped jambo_table" id="tblProcesos">';
        $html.= '<thead>';
        $html.= '<tr><th>ACCIONES</th><th>NOMBRE</th><th>ASISTENCIA</th><th>EVALUACION</th><th>ESTADO</th></tr>';
        $html.= '</thead>';
        $html.= '<tbody>';
        foreach ($data as $dt)
        {
            $id64 = base64_encode($dt->id);
            $nom  = $dt->Persona->nombre.' '.$dt->Persona->apellido;
            $nm64 = base64_encode($dt->nombre);
            $stat = $dt->id_estado;
            $html.= '<tr>';
            $html.= '<td class="text-center text-nowrap">';
            if($stat==1&&$dt->ModuloEducativo->id_estado==1)
            {
                $html.= $this->BtnHtml('accion(\''.$id64.'\',5,\'ANULAR\')','Anular alumno','times-circle').'&nbsp&nbsp&nbsp&nbsp';
                $html.= $this->BtnHtml('accion(\''.$id64.'\',2,\'RETIRAR\')','Retirar alumno','sign-out').'&nbsp&nbsp&nbsp&nbsp';
                $html.= $this->BtnHtml('nota(\''.$id64.'\',\''.$nom.'\')','Dar nota','check-square-o');
            }
            else
                $html.= $this->BtnHtml(null,'No disponible','ban');
            $html.= '</td>';
            $html.= '<td>'.$nom.'</td>';
            $html.= '<td class="text-nowrap">'.$dt->asistencia.'</td>';
            $html.= '<td class="text-center">'.$dt->evaluacion.'</td>';
            $html.= '<td class="text-center">'.$dt->Estado->descripcion.'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitAgregarAlumno(Request $request)
    {
        $idModulo   = $request->newModulo;
        $idPersona  = $request->idPersona;

        if(isset($idModulo)&&isset($idPersona)&&$idModulo!=''&&$idPersona!='')
        {
            $ModuloA = new tb_modulo_alumno();
            $valida = $ModuloA->ValidaAlumno($idModulo,$idPersona);
            if(isset($valida))
            {
                if(count($valida)==0)
                {
                    $arrayAlumno = [
                        'id_emodulo'        => $idModulo,
                        'id_persona'        => $idPersona,
                        'id_estado'         => 1,
                        'usuario_creacion'  => $this->idUsuario
                    ];

                    if($ModuloA->SetAlumno($arrayAlumno))
                        $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El Alumno fue registrado al Módulo Educativo.','class'=>'info'];
                    else
                        $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'El Alumno ya se encuentra registrado en el Módulo Educativo.','class'=>'error'];
                }
                else
                    $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'El Alumno ya se encuentra registrado en el Módulo Educativo.','class'=>'error'];
            }
            else
                $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'No fue posible validar la existencia del Alumno en el Módulo Educativo.','class'=>'error'];
        }
        else
            $info = ['titulo'=>'ERROR EN TRANSACCION','msg'=>'Los parámetros enviados no son válidos','class'=>'error'];

        Session::flash('mensaje',$info);
        return redirect(url('/procesos/modulos/alumnos'));
    }

    public function InitBuscarModulo(Request $request)
    {
        $idProceso = $request->proceso;
        if(isset($idProceso)&&$idProceso!='')
        {
            $ModuloE    = new tb_modulo_educativo();
            $dataModulo = $ModuloE->FindModulo($idProceso,'');

            if(isset($dataModulo)&&count($dataModulo)>0)
            {
                $select[] = ['id'=>'','text'=>''];
                foreach ($dataModulo as $dm)
                    $select[] = ['id'=>$dm->id,'text'=>$dm->nombre];
                $resp = ['ESTADO'=>'OK','MENSAJE'=>$select];
            }
            else
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No se encontraron Módulos Eductivos para el Proceso selecionado'];
        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos para la búsqueda de Módulos Educativos'];

        return json_encode($resp);
    }

    public function InitEstadoAlumno(Request $request)
    {
        $id64 = $request->data;
        $stat = $request->stat;

        if(isset($id64)&&isset($stat)&&$id64!=''&&$stat!='')
        {
            $ModuloA    = new tb_modulo_alumno();
            $idAlumno   = base64_decode($id64);

            $arrayAlumno = [
                'id_estado'             => $stat,
                'usuario_modificacion'  => $this->idUsuario,
                'fecha_modificacion'    => Carbon::now()->format('Y-m-d H:i:s')
            ];

            if($ModuloA->UpdateAlumno($idAlumno, $arrayAlumno))
            {
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'El estado del Alumno fue modificado exitosamente.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'El estado del Alumno fue modificado.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible modificar el estado del Alumno.'];
        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros enviados no son válidos'];

        return json_encode($resp);
    }

    public function InitCalificacion(Request $request)
    {
        $valida         = $request->estado;
        $estado         = isset($valida)?3:4;
        $id64           = $request->_data;

        if(isset($id64)&&$id64!='')
        {
            $ModuloA    = new tb_modulo_alumno();
            $idAlumno   = base64_decode($id64);

            $arrayAlumno = [
                'asistencia'            => $request->asistencia,
                'evaluacion'            => $request->calificacion,
                'id_estado'             => $estado,
                'observaciones'         => $request->observaciones,
                'fecha_modificacion'    => Carbon::now()->format('Y-m-d H:i:s'),
                'usuario_modificacion'  => $this->idUsuario
            ];

            if($ModuloA->UpdateAlumno($idAlumno, $arrayAlumno))
            {
                $resp = ['ESTADO'=>'OK','MENSAJE'=>'La calificación del Alumno fue registrada exitosamente.'];
                $info = ['titulo'=>'TRANSACCION EXITOSA','msg'=>'La calificación del Alumno fue registrada exitosamente.','class'=>'info'];
                Session::flash('mensaje',$info);
            }
            else
                $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'No fue posible registrar la calificación del Alumno.'];
        }
        else
            $resp = ['ESTADO'=>'ERROR','MENSAJE'=>'Los parámetros envidos no son válidos'];

        return json_encode($resp);
    }

    public function InitEstadisticas(Request $request)
    {
        $usuario        = $this->usuario;
        $tituloPagina   = 'Estadísticas';
        $titulo         = 'Estadísticas de Procesos';
        $subtitulo      = '';

        $isChart = true;

        $ModuloA = new tb_modulo_alumno();
        $ModuloE = new tb_modulo_educativo();
        $dataModulo = $ModuloE->TotalByProceso();
        $dataAlumno = $ModuloA->TotalByProceso();

        $chartModulo = json_encode(isset($dataModulo)&&count($dataModulo)>0?$this->FormatPie($dataModulo):[]);
        $chartAlumno = json_encode(isset($dataAlumno)&&count($dataAlumno)>0?$this->FormatBar($dataAlumno):[]);

        return view('modulos.procesos.modulos.estadisticas',get_defined_vars());

    }

    public function FormatPie($data)
    {
        $titles = [];
        $info   = [];

        foreach ($data as $dt)
        {
            $titles[]   = $dt->nombre;
            $info[]     = ['value'=>$dt->total,'name'=>$dt->nombre];
        }

        #dd($titles,$info);
        return [$titles, $info];
    }

    public function FormatBar($data)
    {
        $titles = [];
        $values = [];

        foreach ($data as $dt)
        {
            $titles[] = $dt->nombre;
            $values[] = $dt->total;
        }

        #dd($titles, $values);
        return [$titles, $values];
    }
}
