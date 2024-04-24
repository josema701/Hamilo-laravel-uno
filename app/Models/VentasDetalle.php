<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentasDetalle extends Model
{
    use HasFactory;

    protected $table = 'ventas_detalles';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'total'
    ];

    public function productos(){
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
