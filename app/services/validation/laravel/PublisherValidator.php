<?php

namespace Services\Validation\Laravel;

use Services\Validation\ValidableInterface;

/**
 * Description of PublisherValidator
 *
 * @author Ivan
 */
class PublisherValidator extends LaravelValidator implements ValidableInterface {

    protected $rules = [
            'name' => 'required|unique:publishers,name'
    ];
    
    protected $messages = [
        'name.required' => 'Se ha de insertar un nombre.',
        'name.unique' => 'Ya existe una distribuidora con ese nombre.',
    ];

    public function __construct(\Illuminate\Validation\Factory $validator, $ignoreRowId = null) {
        parent::__construct($validator);

        $ignoreRowId === null ? : $this->rules['name'] .= ",$ignoreRowId";
    }

}
