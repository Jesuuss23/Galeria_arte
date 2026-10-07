<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'cliente_id',
        'artista_id',
        'servicio_id',
        'instrucciones',
        'archivo_referencia',
        'precio_acordado',
        'comision_plataforma',
        'fecha_limite',
        'archivo_entrega_final',
        'motivo_rechazo',
        'resolucion_admin',
        'estado'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function artista()
    {
        return $this->belongsTo(User::class, 'artista_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}