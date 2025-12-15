<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
        'tiempo_estimado',
        'categoria',
    ];

    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'venta_servicio')
                    ->withPivot('costo')
                    ->withTimestamps();
    }
}