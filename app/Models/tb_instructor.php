<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_instructor extends Model
{
    protected $table = 'tb_instructor';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function ModuloInstructor()
    {
        return $this->hasMany('App\Models\tb_modulo_instructor','id_instructor','id');
    }

    public function Persona()
    {
        return $this->belongsTo('App\Models\tb_persona','id_persona','id');
    }

    #METODOS
    public function GetInstructor($estado = null)
    {
        return $this->where(function ($sql) use ($estado){
            if(isset($estado))
                $sql->where('estado',$estado);
        })->with(['Persona'=>function($sql){
            $sql->select('id','nombre','apellido');
        }])->with(['ModuloInstructor'=>function($sql){
            $sql->select('id_instructor',DB::raw('count(*) as total'))->groupBy('id_instructor');
        }])->get();
    }

    public function GetById($id)
    {
        return $this->where('id',$id)->get();
    }

    public function SetInstructor($data)
    {
        return $this->insertGetId($data);
    }

    public function UpdateInstructor($id, $data)
    {
        return $this->where('id',$id)->update($data);
    }
}