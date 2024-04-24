<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'total',
        'estado',
        'usuario_id',
        'cliente_id',
    ];

    // relacion usuario
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function clientes(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
