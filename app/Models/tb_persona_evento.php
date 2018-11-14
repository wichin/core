<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tb_persona_evento extends Model
{
    protected $table = 'tb_persona_evento';
    protected $primaryKey = 'id';

    public function Persona()
    {
        return $this->belongsTo('App\Models\tb_persona','id_persona','id');
    }

    public function Evento()
    {
        return $this->belongsTo('App\Models\tb_evento','id_evento','id');
    }

    #METODOS
    public function ValidaEvento($idPersona, $idEvento)
    {
        return $this->where('id_persona',$idPersona)
            ->where('id_evento',$idEvento)
            ->where('estado',1)
            ->get();
    }

    public function SetEventoPersona($data)
    {
        return $this->insertGetId($data);
    }

    public function GetTotalByEvento()
    {
        return DB::table('tb_persona_evento as pe')
            ->join('tb_evento as e','e.id','=','pe.id_evento')
            ->select('e.nombre',DB::raw('count(*) as total'))
            ->groupBy('pe.id_evento')->get();
    }
}