<?php

class SessionController extends \BaseController {

    /**
     * Store a newly created resource in storage.
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
            return Redirect::to('/')
                            ->withErrors($validator, 'login')
                            ->withInput(Input::except('password'));
        }

        //Validación de las credenciales del usuario
        if (Auth::attempt(Input::only('email', 'password'), true)) {
            return Redirect::to('/');

        }
        
        //No existe usuario con esas credenciales 
        return Redirect::to('/')
                        ->withErrors(['userNotExists' => 'El email o la contraseña son incorrectas.'], 'login')
                        ->withInput(Input::except('password'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Auth::logout();

        return Redirect::to('/');
    }

}
