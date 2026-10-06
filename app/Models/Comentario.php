<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    public $timestamps = false;
    protected $fillable = ['usuario_id', 'obra_id', 'comentario', 'tipo'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function obra()
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }
}