<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_modulo_educativo extends Model
{
    protected $table = 'tb_modulo_educativo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Proceso()
    {
        return $this->belongsTo('App\Models\tb_proceso','id_proceso','id');
    }

    #METODOS
    public function SetModuloEducativo($data)
    {
        return $this->insertGetId($data);
    }
}