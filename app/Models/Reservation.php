<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    /**
     * Tabela do banco de dados
     *
     * @var string
     */
    protected $table = 'reservations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board_id',
        'first_name',
        'last_name',
        'email',
        'tel_number',
        'res_date',
        'completed',
    ];

    /**
     * Atributos da tabela do banco de dados
     *
     * @var array
     */
    protected $casts = [
        'completed' => 'boolean',
    ];

    /**
     * Atributos da tabela do banco de dados
     *
     *  @var array
     */
    protected $dates = [
        'res_date',
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
     * Obtém a mesa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class)->withTrashed();
    }
}
