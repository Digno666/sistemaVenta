<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'TipoUsuario';
    protected $primaryKey = 'codTipoUsuario';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    public function usuarios(){
        return $this->hasMany(User::class, 'codTipoUsuario', 'codTipoUsuario');
    }
}
