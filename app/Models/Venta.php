<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'fecha_venta',
        'subtotal',
        'iva',
        'total',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'fecha_venta' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'venta_servicio')
                    ->withPivot('costo')
                    ->withTimestamps();
    }
}