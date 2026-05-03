<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'Compra';
    protected $primaryKey = 'codCompra';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'fechaCompra',
        'montoTotal',
        'codEncargado',
        'codProveedor',
    ];

    // Relación con Encargado
    public function encargado()
    {
        return $this->belongsTo(Encargado::class, 'codEncargado', 'carnetIdentidad');
    }

    // Relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'codProveedor', 'codProveedor');
    }

    // Relación con DetalleCompra
    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'codCompra', 'codCompra');
    }

    // Accesor para monto formateado
    public function getMontoTotalFormateadoAttribute()
    {
        return 'Bs ' . number_format($this->montoTotal, 2, ',', '.');
    }

    // Accesor para fecha formateada
    public function getFechaCompraFormateadaAttribute()
    {
        return date('d/m/Y', strtotime($this->fechaCompra));
    }
}
