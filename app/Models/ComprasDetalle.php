<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasDetalle extends Model
{
    use HasFactory;

    protected $table = 'compras_datalles';

    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'total'
    ];

    public function productos(){
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
