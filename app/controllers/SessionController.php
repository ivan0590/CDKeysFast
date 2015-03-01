<?php

use Repositories\User\UserRepositoryInterface as UserRepositoryInterface;

class SessionController extends \BaseController {

    public function __construct(UserRepositoryInterface $user) {
        $this->user = $user;
    }

    /**
     * 
     *
     * @return Response
     */
    public function store() {

        //Reglas de validación
        $validationRules = [
            'email' => 'required|email', //Email requerido
            'password' => 'required|alphaNum|min:6' //Contraseña alfanumérica de 6 caracteres requerida
        ];

        //Mensajes de error
        $messages = ['email.required' => 'Formato de email incorrecto.',
            'email.email' => 'Formato de email incorrecto.',
            'password.alphaNum' => 'La contraseña ha de ser alfanumérica.',
            'password.required' => 'La contraseña ha de tener al menos 6 caracteres.',
            'password.min' => 'La contraseña ha de tener al menos 6 caracteres.'];

        //Validación de los campos del formulario
        $validator = Validator::make(Input::all(), $validationRules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'login')
                            ->withInput(Input::except('password'));
        }



        //Las credenciales del usuario son válidas
        if (Auth::validate(Input::only('email', 'password'))) {

            $role = $this->user->getByEmail(Input::get('email'))->userable_type;

            //El cliente todavía no ha confirmado su email
            if ($role === 'Client' && !$this->user->emailConfirmed(Input::get('email'))) {
                return Redirect::back()
                                ->withErrors(['userNotConfirmed' => 'Has de confirmar tu email antes de poder loguearte.'], 'login')
                                ->withInput(Input::except('password'));
            }

            //Se intenta iniciar sesión
            if (Auth::attempt(Input::only('email', 'password'), true)) {
                return $role === 'Admin' ?
                        Redirect::route('product.edition') : //Admin
                        Redirect::back(); //Cliente
            }
        }

        //No existe usuario con esas credenciales 
        return Redirect::back()
                        ->withErrors(['userNotExists' => 'El email o la contraseña son incorrectas.'], 'login')
                        ->withInput(Input::except('password'));
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Auth::logout();

        return Redirect::route('index');
    }

}
