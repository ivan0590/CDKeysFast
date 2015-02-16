<?php

use Repositories\User\UserRepositoryInterface as UserRepositoryInterface;

class UserController extends \BaseController {

    public function __construct(UserRepositoryInterface $user) {
        $this->user = $user;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Registrarse');

        return View::make('client.pages.register')->with('breadcrumbs', Breadcrumb::generate());
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
        
        //Ya existe un usuario con ese email
        if ($this->user->emailExists(Input::get('email'))) {
            return Redirect::route('user.create')
                            ->withErrors(['userExists' => 'Ya existe un usuario con ese email.'], 'register')
                            ->withInput(Input::except('password'));
        }

        $this->user->create(Input::get('email'), Input::get('password'));

        //Se envía el email
        $this->sendConfirmationCode(Input::get('email'));

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Aviso');

        return Redirect::route('info')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('message', '¡Gracias por registrate! Por favor, revisa tu correo.');
    }

    public function sendConfirmationCode($email) {

        $confirmationCode = $this->user->getConfirmationCode($email);

        if ($confirmationCode) {
            Mail::send('emails.verify', ['confirmation_code' => $confirmationCode], function($message) use ($email) {
                $message->to($email)->subject('Verifica tu dirección de correo electrónico');
            });
        }

        return Redirect::back();
    }

    public function confirm($confirmationCode) {


        if (!$confirmationCode) {
            return Redirect::route('info')->withErrors(['errorWithCode' => 'El código de confirmación no es correcto'], 'confirm');
        }

        $user = $this->user->getByConfirmationCode($confirmationCode);

        if (!$user) {
            return Redirect::route('info')->withErrors(['errorWithUser' => 'No hay ningún usuario para ese código de confirmación'], 'confirm');
        }

        $this->user->confirmEmail($user->id);
        
        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Aviso');

        return Redirect::route('info')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('message', 'El email se ha confirmado.');
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
