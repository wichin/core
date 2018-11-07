<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_proceso extends Model
{
    protected $table = 'tb_proceso';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function ModuloEducativo()
    {
        return $this->hasMany('App\Models\tb_modulo_educativo','id_proceso','id');
    }

    #METODOS
    public function GetProcesos($estado = null)
    {
        return $this->where(function ($sql) use($estado){
            if(isset($estado))
                $sql->where('estado',$estado);
        })->with(['ModuloEducativo'=>function($sql){
            $sql->select('id_proceso',DB::raw('count(*) as total'))->groupBy('id_proceso');
        }])->get();
    }

    public function ValidaNombre($nombre)
    {
        return $this->where(DB::raw('UPPER(nombre)'),mb_strtoupper($nombre))->get();
    }

    public function SetProceso($data)
    {
        return $this->insertGetId($data);
    }

    public function UpdateProceso($id, $data)
    {
        return $this->where('id',$id)->update($data);
    }
}