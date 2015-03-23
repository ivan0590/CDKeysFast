<?php

namespace Services\Validation\Laravel;

use Services\Validation\ValidableInterface;

/**
 * Description of SessionValidator
 *
 * @author Ivan
 */
class SessionValidator extends LaravelValidator implements ValidableInterface {

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required|alpha_dash|min:6'
    ];
    
    protected $messages = [
        'email.required' => 'Se ha de introducir un email.',
        'email.email' => 'Formato de email incorrecto.',
        'email.exists' => 'El email o la contraseña son incorrectos.',
        'password.alpha_dash' => 'Solo se admiten letras, números, guiones bajos y barras.',
        'password.required' => 'La contraseña ha de tener al menos 6 caracteres.',
        'password.min' => 'La contraseña ha de tener al menos 6 caracteres.'
    ];

}
