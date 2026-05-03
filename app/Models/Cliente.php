<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'Cliente';
    protected $primaryKey = 'carnetIdentidad';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'carnetIdentidad',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'edad',
        'sexo',
        'celular',
        'codUsuario',
        'foto',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'codUsuario', 'codUsuario');
    }
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellidoPaterno} {$this->apellidoMaterno}";
    }
    public function getSexoFormateadoAttribute()
    {
        return $this->sexo === 'M' ? 'Masculino' : 'Femenino';
    }
    public function getFotoUrlAttribute()
    {
        if ($this->foto && file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }
}
