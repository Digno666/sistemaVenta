<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Producto';
    protected $primaryKey = 'codProducto';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'codProducto',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'codCategoria',
    ];

    // Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'codCategoria', 'codCategoria');
    }

    // Accesor para precio formateado
    public function getPrecioFormateadoAttribute()
    {
        return 'Bs ' . number_format($this->precio, 0, ',', '.');
    }
    public function getImagenUrlAttribute()
    {
        if ($this->imagen && file_exists(public_path('storage/' . $this->imagen))) {
            return asset('storage/' . $this->imagen);
        }
        return asset('images/product-placeholder.png');
    }
    public function detallesCompra()
    {
        return $this->hasMany(DetalleCompra::class, 'codProducto', 'codProducto');
    }
    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'codProducto', 'codProducto');
    }
}
