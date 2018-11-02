<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_aplicacion extends Model
{
    protected $table = 'tb_aplicacion';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Menu()
    {
        return $this->belongsTo('\App\Models\tb_menu','id_menu','id');
    }

    #METODOS
    public function GetAplicacion($estado = null)
    {
        return $this->where(function ($sql) use ($estado){
            if(isset($estado))
                $sql->where('estado',$estado);
        })->with('Menu.Modulo')->orderBy('id_menu')->get();
    }

    public function ValidaNombre($nombre, $idMenu=null)
    {
        return $this->where(DB::raw('UPPER(nombre)'),mb_strtoupper($nombre))
            ->where(function ($sql) use ($idMenu){
                if(isset($idMenu))
                    $sql->where('id_menu',$idMenu);
            })->get();
    }

    public function SetAplicacion($data)
    {
        return $this->insertGetId($data);
    }
}