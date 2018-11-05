<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_persona extends Model
{
    protected $table = 'tb_persona';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function PersonaEvento()
    {
        return $this->hasMany('App\Models\tb_persona_evento','id_persona','id');
    }

    public function PersonaMinisterio()
    {
        return $this->hasMany('App\Models\tb_persona_ministerio','id_persona','id');
    }

    public function PersonaProceso()
    {
        return $this->hasMany('App\Models\tb_persona_proceso','id_persona','id');
    }

    public function Usuario()
    {
        return $this->hasMany('App\Models\tb_usuario','id_persona','id');
    }

    public function Sexo()
    {
        return $this->belongsTo('App\Models\cat_sexo','id_sexo','id');
    }

    public function Grupo()
    {
        return $this->belongsTo('App\Models\cat_grupo','id_grupo','id');
    }

    #OPERACIONES
    public function InsertGetId($data)
    {
        return $this->Insert($data);
    }

    public function UpdateById($id, $data)
    {
        return $this->where('id',$id)->update($data);
    }

    #CONSULTAS
    public function GetFullData($idPersona = null)
    {
        return $this->where(function ($sql) use($idPersona){
            if(isset($idPersona))
                $sql->where('id',$idPersona);
        })->with('Sexo','Grupo')->take(100)->get();
    }

    public function GetPersonaByNombre($cadena)
    {
        return DB::table('tb_persona as p')
            ->leftJoin('tb_usuario as u','u.id_persona','=','p.id')
            ->where(function ($sql) use($cadena){
                $sql->where(DB::raw('UPPER(nombre)'),'like','%'.$cadena.'%');
                $sql->orWhere(DB::raw('UPPER(apellido)'),'like','%'.$cadena.'%');
            })->whereNull('u.id')
            ->select('p.id','p.nombre','p.apellido')->get();
    }

    public function GetPersonaByNombreFull($cadena)
    {
        return $this->where(function ($sql) use($cadena){
            $sql->where(DB::raw('UPPER(nombre)'),'like','%'.$cadena.'%');
            $sql->orWhere(DB::raw('UPPER(apellido)'),'like','%'.$cadena.'%');
        })->select('id','nombre','apellido')->get();
    }

    public function GetDetalle($idPersona)
    {

    }
}