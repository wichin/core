<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_persona_ministerio extends Model
{
    protected $table = 'tb_persona_ministerio';
    protected $primaryKey = 'id';

    public function Persona()
    {
        return $this->belongsTo('App\Models\tb_persona','id_persona','id');
    }

    public function Ministerio()
    {
        return $this->belongsTo('App\Models\tb_ministerio','id_ministerio','id');
    }
}