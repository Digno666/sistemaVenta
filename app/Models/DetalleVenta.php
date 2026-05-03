<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'DetalleVenta';
    protected $primaryKey = ['codVenta', 'codProducto'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'precioVenta',
        'cantidad',
        'codVenta',
        'codProducto',
    ];

    // Relación con Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'codVenta', 'codVenta');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codProducto', 'codProducto');
    }

    // Accesor para subtotal
    public function getSubtotalAttribute()
    {
        return $this->precioVenta * $this->cantidad;
    }

    // Accesor para precio formateado
    public function getPrecioVentaFormateadoAttribute()
    {
        return 'Bs ' . number_format($this->precioVenta, 2, ',', '.');
    }
}
