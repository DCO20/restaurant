<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    /**
     * Tabela do banco de dados
     *
     * @var string
     */
    protected $table = 'boards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'guest_number',
        'available',
    ];

    /**
     * Atributos da tabela do banco de dados
     *
     * @var array
     */
    protected $casts = [
        'available' => 'boolean',
    ];

    /**
     * Atributos da tabela do banco de dados
     *
     *  @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    |
    | Definição dos métodos das entidades relacionadas.
    | Estes métodos são responsáveis pelas relações e permitem acessar
    | os atributos Eloquent obtidas das mesmas.
    |
    */

    /**
     * Obtêm as reservas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class)->withTrashed();
    }
}
