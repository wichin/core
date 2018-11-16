<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_modulo_educativo extends Model
{
    protected $table = 'tb_modulo_educativo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function ModuloInstructor()
    {
        return $this->hasMany('App\Models\tb_modulo_instructor','id_emodulo','id');
    }

    public function ModuloAlumno()
    {
        return $this->hasMany('App\Models\tb_modulo_alumno','id_emodulo','id');
    }

    public function Proceso()
    {
        return $this->belongsTo('App\Models\tb_proceso','id_proceso','id');
    }

    public function Estado()
    {
        return $this->belongsTo('App\Models\cat_estado_modulo','id_estado','id');
    }

    public function TipoReunion()
    {
        return $this->belongsTo('App\Models\cat_tipo_reunion','id_tipo_reunion','id');
    }

    #METODOS
    public function SetModuloEducativo($data)
    {
        return $this->insertGetId($data);
    }

    public function FindModulo($proceso, $estado)
    {
        return $this->where(function ($sql) use($proceso,$estado){
            if(isset($proceso)&&$proceso!='')
                $sql->where('id_proceso',$proceso);
            if(isset($estado)&&$estado!='')
                $sql->where('id_estado',$estado);
        })->with('Proceso','Estado','TipoReunion')->orderBy('id_proceso')->get();
    }

    public function UpdateModulo($id, $data)
    {
        return $this->where('id',$id)->update($data);
    }

    public function TotalByProceso()
    {
        return DB::table('tb_modulo_educativo as me')
            ->join('tb_proceso as p','p.id','=','me.id_proceso')
            ->select('p.nombre',DB::raw('count(*) as total'))
            ->groupBy('me.id_proceso')->get();
    }
}