<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'nombre',
        'precio_venta',
        'precio_compra',
        'descripcion',
        'estado',
        'usuario_id'
    ];

    // relacion con usuarios (users)
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

}
