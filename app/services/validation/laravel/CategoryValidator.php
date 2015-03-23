<?php

namespace Services\Validation\Laravel;

use Services\Validation\ValidableInterface;

/**
 * Description of CategoryValidator
 *
 * @author Ivan
 */
class CategoryValidator extends LaravelValidator implements ValidableInterface {

    protected $rules = [
        'name' => 'required|unique:categories,name',
        'description' => 'string',
    ];
    
    protected $messages = [
        'name.required' => 'Se ha de insertar un nombre.',
        'name.unique' => 'Ya existe una categoría con ese nombre.',
        'description.string' => 'La descripción ha de ser una cadena de texto.',
    ];

    public function __construct(\Illuminate\Validation\Factory $validator, $ignoreRowId = null) {
        parent::__construct($validator);

        $ignoreRowId === null ? : $this->rules['name'] .= ",$ignoreRowId";
    }

}
