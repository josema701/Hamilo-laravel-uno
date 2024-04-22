<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedors';

    protected $fillable = [
        'nombre',
        'apellido',
        'contacto',
        'identificacion',
        'estado',
        'usuario_id'
    ];
    // relacion con usuarios (users)
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
