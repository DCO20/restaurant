<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Menu extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * Tabela do banco de dados
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'price',
        'description',
    ];

    /**
     * Trativa da tabela do banco de dados
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Atributos da tabela do banco de dados
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    |
    | Definição dos métodos GET desta entidade.
    | Estes métodos permitem formatar os atributos Eloquent obtidos do banco de dados.
    |
    */

    /**
     * Formata o atributo
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->attributes['price'], 2, ',', '.');
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    |
    | Definição dos métodos SET desta entidade.
    | Estes métodos permitem formatar os atributos para o banco de dados.
    |
    */

    /**
     * Formata o atributo
     *
     * @return void
     */
    public function setPriceAttribute($value)
    {
        $formatted_value = str_replace(',', '.', str_replace('.', '', $value));

        $this->attributes['price'] = $formatted_value;
    }

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
     * Obtêm os categorias
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTrashed();
    }
}
