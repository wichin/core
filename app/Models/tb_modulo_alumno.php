<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_modulo_alumno extends Model
{
    protected $table = 'tb_modulo_alumno';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Persona()
    {
        return $this->belongsTo('App\Models\tb_persona','id_persona','id');
    }

    public function ModuloEducativo()
    {
        return $this->belongsTo('App\Models\tb_modulo_educativo','id_emodulo','id');
    }

    public function Estado()
    {
        return $this->belongsTo('App\Models\cat_estado_alumno','id_estado','id');
    }

    #METODOS
    public function ValidaAlumno($idModulo, $idPersona)
    {
        return $this->where('id_emodulo',$idModulo)->where('id_persona',$idPersona)->get();
    }

    public function SetAlumno($data)
    {
        return $this->insertGetId($data);
    }

    public function UpdateAlumno($id, $data)
    {
        return $this->where('id',$id)->update($data);
    }

    public function GetByModulo($idModulo)
    {
        return $this->where('id_emodulo',$idModulo)
            ->with(['Persona'=>function($sql){
                $sql->select('id','nombre','apellido')->orderBy('apellido')->orderBy('nombre');
            }])->with('ModuloEducativo')
            ->get();
    }

    public function TotalByProceso()
    {
        return DB::table('tb_modulo_alumno as ma')
            ->join('tb_modulo_educativo as m','m.id','=','ma.id_emodulo')
            ->join('tb_proceso as p','p.id','=','m.id_proceso')
            ->select('ma.id','p.nombre')
            ->select('p.nombre',DB::raw('count(*) as total'))
            ->groupBy('m.id_proceso')
            ->get();
    }
}