<?php

namespace Services\Validation\Laravel;

use Services\Validation\ValidableInterface;

/**
 * Description of GameValidator
 *
 * @author Ivan
 */
class GameValidator extends LaravelValidator implements ValidableInterface {

    protected $rules = [
        'name' => 'required|unique:games,name',
        'category_id' => 'exists:categories,id',
        'agerate_id' => 'exists:agerates,id',
        'description' => 'string',
        'thumbnail_image_path' => 'mimes:jpeg,jpg,png|image|max:1024|image_size:256,256',
        'offer_image_path' => 'mimes:jpeg,jpg,png|image|max:2048|image_size:1920,1080'
    ];
    
    protected $messages = [
        'name.required' => 'Se ha de insertar un nombre.',
        'name.unique' => 'Ya existe un juego con ese nombre.',
        'category_id.exists' => 'La categoría no existe.',
        'agerate_id.exists' => 'La calificación por edad no existe.',
        'description.string' => 'La descripción ha de ser una cadena de texto.',
        'thumbnail_image_path.mimes' => 'La miniatura ha de estar en formato jpg o png.',
        'thumbnail_image_path.image' => 'La miniatura ha de ser una imagen.',
        'thumbnail_image_path.max' => 'El tamaño máximo de la miniatura es de 1MB.',
        'thumbnail_image_path.image_size' => 'Las dimensiones de la miniatura han de ser de 256x256 píxeles.',
        'offer_image_path.mimes' => 'La imagen de oferta ha de estar en formato jpg o png.',
        'offer_image_path.image' => 'La imagen de oferta ha de ser una imagen.',
        'offer_image_path.max' => 'El tamaño máximo de la imagen de oferta es de 2MB.',
        'offer_image_path.image_size' => 'Las dimensiones de la imagen de oferta han de ser de 1920x1080 píxeles.',
    ];

    public function __construct(\Illuminate\Validation\Factory $validator, $ignoreRowId = null) {
        parent::__construct($validator);

        $ignoreRowId === null ? : $this->rules['name'] .= ",$ignoreRowId";
    }

}
