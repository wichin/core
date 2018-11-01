<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_proceso extends Model
{
    protected $table = 'tb_tb_proceso';
    protected $primaryKey = 'id';

    public function PersonaProceso()
    {
        return $this->hasMany('App\Models\tb_persona_proceso','id_proceso','id');
    }
}