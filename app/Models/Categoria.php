<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'Categoria';
    protected $primaryKey = 'codCategoria';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'codCategoria',
        'nombre',
        'descripcion',
    ];
    public function productos()
    {
        return $this->hasMany(Producto::class, 'codCategoria', 'codCategoria');
    }
}
