<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = [
        'total',
        'estado',
        'usuario_id',
        'proveedor_id',
    ];

    // relacion usuario
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function proveedores(){
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
