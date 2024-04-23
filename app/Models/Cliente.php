<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'identificacion',
        'estado',
        'usuario_id',
    ];

    // relacion usuario
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
