<?php

class UserController extends \BaseController {

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('client.pages.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {

        //Reglas de validación
        $validationRules = [
            'email' => 'required|email|confirmed', //Email requerido
            'password' => 'required|alphaNum|min:6|confirmed' //Contraseña alfanumérica de 6 caracteres requerida'
        ];

        //Mensajes de error
        $messages = ['email.required' => 'Formato de email incorrecto.',
            'email.email' => 'Formato de email incorrecto.',
            'email.confirmed' => 'Los emails no coinciden',
            'password.alphaNum' => 'La contraseña ha de ser alfanumérica.',
            'password.required' => 'La contraseña ha de tener al menos 6 caracteres.',
            'password.min' => 'La contraseña ha de tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make(Input::all(), $validationRules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::route('user.create')
                            ->withErrors($validator, 'register')
                            ->withInput(Input::except('password'));
        }

        $userExists = !User::where('email', Input::get('email'))->get()->isEmpty();


        //Ya existe un usuario con ese email
        if ($userExists) {
            return Redirect::route('user.create')
                            ->withErrors(['userExists' => 'Ya existe un usuario con ese email.'], 'register')
                            ->withInput(Input::except('password'));
        }

        //Código de confirmación
        $confirmationCode = str_random(30);

        //Se crea el usuario
        $user = new User;
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->confirmed = false;
        $user->confirmation_code = $confirmationCode;
        $user->save();

        //Se envía el email
        Mail::send('emails.verify', ['confirmation_code' => $confirmationCode], function($message) {
            $message->to(Input::get('email'))
                    ->subject('Verifica tu dirección de correo electrónico');
        });

        return Redirect::route('info')->with('message', '¡Gracias por registrate! Por favor, revisa tu correo.');
    }

    public function confirm($confirmationCode) {


        if (!$confirmationCode) {
            return Redirect::route('info')->withErrors(['errorWithCode' => 'El código de confirmación no es correcto'], 'confirm');
        }

        $user = User::where('confirmation_code', '=', $confirmationCode)->first();

        if (!$user) {
            return Redirect::route('info')->withErrors(['errorWithUser' => 'No hay ningún usuario para ese código de confirmación'], 'confirm');
        }

        $user->confirmed = true;
        $user->confirmation_code = null;
        $user->save();

        return Redirect::route('info')->with('message', 'El email se ha confirmado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function putEmail($id) {
        //
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function putPassword($id) {
        
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function putPersonalData($id) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
