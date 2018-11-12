<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_modulo_instructor extends Model
{
    protected $table = 'tb_modulo_instructor';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function ModuloEducativo()
    {
        return $this->belongsTo('App\Models\tb_modulo_educativo','id_emodulo','id');
    }

    public function Instructor()
    {
        return $this->belongsTo('App\Models\tb_instructor','tb_instructor','id');
    }

    #METODOS
    public function GetInstructorDisponible($idModulo)
    {
        return DB::table('tb_instructor as i')
            ->join('tb_persona as p','p.id','=','i.id_persona')
            ->leftJoin('tb_modulo_instructor as mi',function ($sql) use ($idModulo){
                $sql->on('i.id','=','mi.id_instructor');
                $sql->on('mi.id_emodulo','=',DB::raw($idModulo));
            })
            ->where('i.estado',1)
            ->whereNull('mi.id')
            ->select('i.id','p.nombre','p.apellido')
            ->get();
    }

    public function InsertMod($data)
    {
        return $this->insert($data);
    }
}