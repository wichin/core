<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_evento extends Model
{
    protected $table = 'tb_evento';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function PersonaEvento()
    {
        return $this->hasMany('App\Models\tb_persona_evento','id_evento','id');
    }

    #METODOS
    public function GetEvento($estado = null)
    {
        return $this->where(function ($sql) use($estado){
            if(isset($estado))
                $sql->where('estado',$estado);
        })->with(['PersonaEvento'=>function($sql){
            $sql->select('id_evento',DB::raw('count(*) as total'))->groupBy('id_evento');
        }])->get();
    }

    public function ValidaNombre($nombre)
    {
        return $this->where(DB::raw('UPPER(nombre)'),mb_strtoupper($nombre))->get();
    }

    public function SetEvento($data)
    {
        return $this->insertGetId($data);
    }

    public function UpdateEvento($id, $data)
    {
        return $this->where('id',$id)->update($data);
    }
}