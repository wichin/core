<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_modulo extends Model
{
    protected $table = 'tb_modulo';
    protected $primaryKey = 'id';

    public function Menu()
    {
        return $this->hasMany('\App\Models\tb_menu','id_modulo','id');
    }
}