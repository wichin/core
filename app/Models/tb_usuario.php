<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_usuario extends Model
{
    protected $table = 'tb_usuario';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Persona()
    {
        return $this->belongsTo('App\Models\tb_persona','id_persona','id');
    }

    #METODOS
    public function GetUsuario($estado = null)
    {
        return $this->where(function ($sql) use ($estado){
            if(isset($estado))
                $sql->where('estado',$estado);
        })->get();
    }

    public function ValidaCorreo($correo)
    {
        return $this->where(DB::raw('UPPER(email)'),mb_strtoupper($correo))->get();
    }

    public function SetUsuario($data)
    {
        return $this->insertGetId($data);
    }

}