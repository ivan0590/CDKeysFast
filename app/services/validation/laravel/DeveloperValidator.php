<?php

namespace Services\Validation\Laravel;

use Services\Validation\ValidableInterface;

/**
 * Description of DeveloperValidator
 *
 * @author Ivan
 */
class DeveloperValidator extends LaravelValidator implements ValidableInterface {

    protected $rules = [
        'name' => 'required|unique:developers,name'
    ];
    protected $messages = [
        'name.required' => 'Se ha de insertar un nombre.',
        'name.unique' => 'Ya existe una desarrolladora con ese nombre.',
    ];

    public function __construct(\Illuminate\Validation\Factory $validator, $ignoreRowId = null) {
        parent::__construct($validator);

        $ignoreRowId === null ? : $this->rules['name'] .= ",$ignoreRowId";
    }

}
