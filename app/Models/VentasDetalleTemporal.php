<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentasDetalleTemporal extends Model
{
    use HasFactory;

    protected $table = 'ventas_detalle_temporals';

    protected $fillable = [
        'usuario_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'total'
    ];

    public function productos(){
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
