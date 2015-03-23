<?php

namespace Services\Validation\Laravel;

use Services\Validation\ValidableInterface;

/**
 * Description of PlatformValidator
 *
 * @author Ivan
 */
class PlatformValidator extends LaravelValidator implements ValidableInterface {

    
    protected $rules = [
        'name' => 'required|unique:platforms,name',
        'icon_path' => 'mimes:svg',
        'description' => 'string',
    ];
    
    protected $messages = [
        'name.required' => 'Se ha de insertar un nombre.',
        'name.unique' => 'Ya existe una plataforma con ese nombre.',
        'icon_path.mimes' => 'El icono ha de ser un archivo SVG.',
        'description.string' => 'La descripción ha de ser una cadena de texto.',
    ];


    public function __construct(\Illuminate\Validation\Factory $validator, $ignoreRowId = null) {
        parent::__construct($validator);
        
        $ignoreRowId === null ?: $this->rules['name'] .= ",$ignoreRowId";
    }
}
