<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_menu extends Model
{
    protected $table = 'tb_menu';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Aplicacion()
    {
        return $this->hasMany('\App\Models\tb_aplicacion','id_menu','id');
    }

    public function Modulo()
    {
        return $this->belongsTo('\App\Models\tb_modulo','id_modulo','id');
    }

    #METODOS
    public function GetMenu($estado = null)
    {
        return $this->where(function ($sql) use($estado){
            if(isset($estado))
                $sql->where('estado',$estado);
        })->with('Modulo')->orderBy('id_modulo')->get();
    }

    public function GetMenuByModulo($idModulo, $estado = null)
    {
        return $this->where('id_modulo',$idModulo)
            ->where(function ($sql) use($estado){
                if(isset($estado))
                    $sql->where('estado',$estado);
            })->orderBy('nombre')->get();
    }

    public function ValidaNombre($nombre, $idModulo = null)
    {
        return $this->where(DB::raw('UPPER(nombre)'),mb_strtoupper($nombre))
            ->where(function ($sql) use ($idModulo){
                if(isset($idModulo))
                    $sql->where('id_modulo',$idModulo);
            })->get();
    }

    public function SetMenu($data)
    {
        return $this->insertGetId($data);
    }

    public function UpdateMenu($id, $data)
    {
        return $this->where('id',$id)->update($data);
    }
}