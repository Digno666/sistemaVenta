<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'DetalleCompra';
    protected $primaryKey = ['codCompra', 'codProducto'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'precioCompra',
        'cantidad',
        'codCompra',
        'codProducto',
    ];

    // Relación con Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'codCompra', 'codCompra');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codProducto', 'codProducto');
    }

    // Accesor para subtotal
    public function getSubtotalAttribute()
    {
        return $this->precioCompra * $this->cantidad;
    }

    // Accesor para precio formateado
    public function getPrecioCompraFormateadoAttribute()
    {
        return 'Bs ' . number_format($this->precioCompra, 2, ',', '.');
    }
}
