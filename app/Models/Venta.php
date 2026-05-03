<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'Venta';
    protected $primaryKey = 'codVenta';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'fechaVenta',
        'montoTotal',
        'codEncargado',
        'codCliente',
    ];

    // Relación con Encargado
    public function encargado()
    {
        return $this->belongsTo(Encargado::class, 'codEncargado', 'carnetIdentidad');
    }

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'codCliente', 'carnetIdentidad');
    }

    // Relación con DetalleVenta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'codVenta', 'codVenta');
    }

    // Accesor para monto formateado
    public function getMontoTotalFormateadoAttribute()
    {
        return 'Bs ' . number_format($this->montoTotal, 2, ',', '.');
    }

    // Accesor para fecha formateada
    public function getFechaVentaFormateadaAttribute()
    {
        return date('d/m/Y', strtotime($this->fechaVenta));
    }
}
