<?php

namespace Services\Validation\Laravel;

use Services\Validation\ValidableInterface;

/**
 * Description of ProductValidator
 *
 * @author Ivan
 */
class ProductValidator extends LaravelValidator implements ValidableInterface {

    protected $rules = [
        'game_id' => 'exists:games,id|unique_with:products,platform_id',
        'platform_id' => 'exists:platforms,id',
        'publisher_id' => 'exists:publishers,id',
        'price' => 'numeric|min:0.01',
        'discount' => 'numeric|min:0|max:100',
        'stock' => 'integer|min:0',
        'launch_date' => 'date',
        'highlighted' => 'boolean',
        'singleplayer' => 'boolean',
        'multiplayer' => 'boolean',
        'cooperative' => 'boolean',
        'text' => 'array|exists:languages,id',
        'audio' => 'array|exists:languages,id',
        'developer' => 'array|exists:developers,id'
    ];
    
    protected $messages = [
        'game_id.exists' => 'El juego no existe.',
        'game_id.unique_with' => 'Ya hay un producto para ese juego y esa plataforma.',
        'platform_id.exists' => 'La plataforma no existe.',
        'publisher_id.exists' => 'La distribuidora no existe.',
        'price.numeric' => 'El precio ha de ser un número.',
        'price.min' => 'El precio ha de ser como mínimo de 0.01€.',
        'discount.numeric' => 'El descuento ha de ser un número.',
        'discount.min' => 'El descuento ha de ser como mínimo del 0%.',
        'discount.max' => 'El descuento ha de ser como máximo del 100%.',
        'stock.integer' => 'El stock ha de ser un valor entero.',
        'stock.min' => 'El stock ha de ser como mínimo de 0 unidades.',
        'launch_date.date' => 'La fecha de lanzamiento no es una fecha válida.',
        'highlighted.boolean' => 'El campo "Sestacado" es incorrecto.',
        'singleplayer.boolean' => 'El campo "Un jugador" es incorrecto.',
        'multiplayer.boolean' => 'El campo "Multijugador" es incorrecto.',
        'cooperative.boolean' => 'El campo "Cooperativo" es incorrecto.',
        'text.array' => 'Error en los lenguajes del texto seleccionados.',
        'text.exists' => 'Uno o más lenguajes del texto no existen.',
        'audio.array' => 'Error en los lenguajes del audio seleccionados.',
        'audio.exists' => 'Uno o más lenguajes del audio no existen.',
        'developer.array' => 'Error en las desarrolladoras seleccionadas.',
        'developer.exists' => 'Una o más desarrolladoras no existen.',
    ];

    public function __construct(\Illuminate\Validation\Factory $validator, $ignoreRowId = null) {
        parent::__construct($validator);

        $ignoreRowId === null ? : $this->rules['game_id'] .= ",$ignoreRowId";
    }

}
