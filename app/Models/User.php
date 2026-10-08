<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Servicio;
use App\Models\Pedido;
use App\Models\Obra;
class User extends Authenticatable
{
    public $timestamps = false;
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'es_anonimo',
        'contacto_url',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function nombreVisible()
    {
        return $this->es_anonimo ? 'Anónimo' : $this->name;
    }
    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'user_id');
    }

    public function pedidosComoCliente()
    {
        return $this->hasMany(Pedido::class, 'cliente_id');
    }

    public function pedidosComoArtista()
    {
        return $this->hasMany(Pedido::class, 'artista_id');
    }

    // Escopo para listar artistas disponíveis para contratação
    public function scopeArtistasDisponibles($query)
    {
        return $query->where('es_publico', true);
    }
    public function obras()
    {
        return $this->hasMany(Obra::class, 'usuario_id');
    }
}
