<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    public $timestamps = false;
    protected $fillable = ['usuario_id', 'categoria_id', 'titulo', 'descripcion', 'herramientas','archivo_imagen'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'obra_id')->latest('id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'obra_id');
    }
}