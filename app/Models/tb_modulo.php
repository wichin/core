<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_modulo extends Model
{
    protected $table = 'tb_modulo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Menu()
    {
        return $this->hasMany('\App\Models\tb_menu','id_modulo','id');
    }

    #METODOS
    public function GetModulos($estado = null)
    {
        return $this->where(function ($sql) use ($estado){
            if(isset($estado))
                $sql->where('estado',$estado);
        })->get();
    }

    public function ValidaNombre($nombre)
    {
        return $this->where(DB::raw('UPPER(nombre)'),mb_strtoupper($nombre))->get();
    }

    public function SetModulo($data)
    {
        return $this->insertGetId($data);
    }

    public function UpdateModulo($id,$data)
    {
        return $this->where('id',$id)->update($data);
    }
}