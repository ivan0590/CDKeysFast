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
            'password.confirmed' => 'Las contraseñas no coinciden.'
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

        $this->user->create(Input::get('email'), Input::get('password'), 'client');

        $user = $this->user->getByEmail(Input::get('email'));

        //Se envía el email
        Mail::send('emails.verify', ['id' => $user->id, 'confirmation_code' => $user->confirmation_code], function($message) {
            $message->to(Input::get('email'))->subject('Verifica tu dirección de correo electrónico');
        });

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Aviso');

        return Redirect::route('info')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('message', '¡Gracias por registrate! Por favor, revisa tu correo.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Editar perfil');

        return View::make('client.pages.edit_profile')
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    
    
    
    
    

    public function updateEmail($id) {

        if ($id != Auth::id()) {
            return Redirect::back();
        }

        //Campos
        $fields = Input::only(['email', 'email_confirmation']);

        //Reglas de validación
        $validationRules = ['email' => 'required|email|confirmed|unique:users'];

        //Mensajes de error
        $messages = [
            'email.required' => 'Formato de email incorrecto.',
            'email.email' => 'Formato de email incorrecto.',
            'email.confirmed' => 'Los emails no coinciden.',
            'email.unique' => 'El email es el mismo o ya existe otro usuario con ese email.'];

        //Validación de los campos del formulario
        $validator = Validator::make($fields, $validationRules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'email')
                            ->withInput($fields);
        }

        $this->user->setChangeEmail(Auth::id(), Input::get('email'));

        //Se envía el email
        Mail::send('emails.update_email', ['id' => Auth::id(), 'change_email_code' => Auth::user()->change_email_code], function($message) {
            $message->to(Auth::user()->email)->subject('Confirmación de cambio de correo electrónico');
        });

        return Redirect::back()
                        ->with(['email_success' => 'Se ha enviado un email para confirmar el cambio.']);
    }

    public function updatePassword($id) {

        if ($id != Auth::id()) {
            return Redirect::back();
        }

        //Campos
        $fields = Input::only(['password', 'password_confirmation']);

        //Reglas de validación
        $validationRules = ['password' => 'required|alphaNum|min:6|confirmed|unique:users,password,NULL,id,id,' . Auth::id()];

        //Mensajes de error
        $messages = [
            'password.alphaNum' => 'La contraseña ha de ser alfanumérica.',
            'password.required' => 'La contraseña ha de tener al menos 6 caracteres.',
            'password.min' => 'La contraseña ha de tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.unique' => 'La contraseña es la misma que la actual.'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($fields, $validationRules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'password')
                            ->withInput($fields);
        }

        $this->user->setChangePassword(Auth::id(), Hash::make(Input::get('password')));

        //Se envía el email
        Mail::send('emails.update_password', ['id' => Auth::id(), 'change_password_code' => Auth::user()->change_password_code], function($message) {
            $message->to(Auth::user()->email)->subject('Confirmación de cambio de contraseña');
        });

        return Redirect::back()
                        ->with(['password_success' => 'Se ha enviado un email para confirmar el cambio.']);
    }

    public function updatePersonal($id) {

        if ($id != Auth::id()) {
            return Redirect::back();
        }

        //Campos
        $fields = Input::only(['name', 'surname', 'birthdate', 'dni']);

        //Reglas de validación
        $validationRules = ['date' => 'date'];

        //Mensajes de error
        $messages = [
            'birthdate.date' => 'Fecha incorrecta'];

        //Validación de los campos del formulario
        $validator = Validator::make($fields, $validationRules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'password')
                            ->withInput($fields);
        }

        $this->user->updateClientPersonalData(Auth::id(),
                                                    Input::get('name') ?: Auth::user()->name,
                                                    Input::get('surname') ?: Auth::user()->surname,
                                                    Input::get('birthdate') ?: Auth::user()->userable->birthdate,
                                                    Input::get('dni') ?: Auth::user()->userable->dni);
        
        return Redirect::back()
                        ->with(['personal_success' => 'Se han guardado los cambios.']);
    }

    public function unsuscribe($id) {
        
        if ($id != Auth::id()) {
            return Redirect::back();
        }
        
        $this->user->setUnsuscribe(Auth::id());

        //Se envía el email
        Mail::send('emails.unsuscribe', ['id' => Auth::id(), 'unsuscribe_code' => Auth::user()->unsuscribe_code], function($message) {
            $message->to(Auth::user()->email)->subject('Confirmación de eliminación de cuenta');
        });

        return Redirect::back()
                        ->with(['password_success' => 'Se ha enviado un email para confirmar la baja.']);
    }

    
    
    
    
    
    
    
    
    
    public function confirm($id, $confirmationCode) {

        $user = $this->user->getById($id);

        if (!$user || !$confirmationCode || $user->confirmation_code !== $confirmationCode) {
            return Redirect::route('info')->withErrors(['errorWithCode' => 'Error de confirmación'], 'confirm');
        }

        $this->user->confirm($user->id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Aviso');

        return Redirect::route('info')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('message', 'El usuario se ha confirmado.');
    }

    public function confirmEmail($id, $changeEmailCode) {

        $user = $this->user->getById($id);

        if (!$user || !$changeEmailCode || $user->change_email_code !== $changeEmailCode) {
            return Redirect::route('info')->withErrors(['errorWithCode' => 'Error de confirmación'], 'confirm');
        }

        $this->user->confirmChangeEmail($user->id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Aviso');

        return Redirect::route('info')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('message', 'El cambio de contraseña se ha confirmado.');
    }

    public function confirmPassword($id, $changePasswordCode) {

        $user = $this->user->getById($id);

        if (!$user || !$changePasswordCode || $user->change_password_code !== $changePasswordCode) {
            return Redirect::route('info')->withErrors(['errorWithCode' => 'Error de confirmación'], 'confirm');
        }

        $this->user->confirmChangePassword($user->id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Aviso');

        return Redirect::route('info')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('message', 'El cambio de email se ha confirmado.');
    }

    public function confirmUnsuscribe($id, $unsuscribeCode) {

        $user = $this->user->getById($id);

        if (!$user || !$unsuscribeCode || $user->unsuscribe_code !== $unsuscribeCode) {
            return Redirect::route('info')->withErrors(['errorWithCode' => 'Error al intentar darse de baja'], 'confirm');
        }

        $this->user->confirmUnsuscribe($user->id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Aviso');

        return Redirect::route('info')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('message', 'La baja se ha procesado correctamente.');
    }

    public function sendConfirmationCode($email) {

        $user = $this->user->getByEmail($email);

        if ($user->confirmation_code) {
            //Se envía el email
            Mail::send('emails.verify', ['id' => $user->id, 'confirmation_code' => $user->confirmation_code], function($message) use ($email) {
                $message->to($email)->subject('Verifica tu dirección de correo electrónico');
            });
        }

        return Redirect::back();
    }

}
