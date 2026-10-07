<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'precio_base',
        'dias_entrega',
        'activo'
    ];

    public function artista()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'servicio_id');
    }
}