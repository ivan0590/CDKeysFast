<?php

use Repositories\User\UserRepositoryInterface as UserRepositoryInterface;
use Repositories\Client\ClientRepositoryInterface as ClientRepositoryInterface;

class UserController extends \BaseController {

    public function __construct(UserRepositoryInterface $user, ClientRepositoryInterface $client) {
        $this->user = $user;
        $this->client = $client;
    }

    /**
     * 
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
     * 
     *
     * @return Response
     */
    public function store() {

        //Reglas de validación
        $rules = [
            'email' => 'required|email|confirmed|unique:users,email', //Email requerido
            'password' => 'required|alpha_dash|min:6|confirmed' //Contraseña alfanumérica de 6 caracteres requerida'
        ];

        //Mensajes de error
        $messages = [
            'email.required' => 'Formato de email incorrecto.',
            'email.email' => 'Formato de email incorrecto.',
            'email.confirmed' => 'Los emails no coinciden.',
            'email.unique' => 'Ya existe un usuario con ese email.',
            'password.alpha_dash' => 'Solo se admiten letras, números, guiones bajos y barras.',
            'password.required' => 'La contraseña ha de tener al menos 6 caracteres.',
            'password.min' => 'La contraseña ha de tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make(Input::all(), $rules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'register')
                            ->withInput(Input::except('password'));
        }

        $data = [
            'email' => Input::get('email'),
            'password' => Hash::make(Input::get('password')),
            'confirmed' => false,
            'confirmation_code' => str_random(30)
        ];

        $user = $this->user->create($data);

        $client = $this->client->create([]);

        $client->user()->save($user);


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
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Editar perfil');

        $userData = [
            'email' => Auth::user()->email,
            'name' => Auth::user()->name,
            'surname' => Auth::user()->surname,
            'birthdate' => Auth::user()->birthdate > 0 ? date_format(new dateTime(Auth::user()->birthdate), 'd-m-Y') : '',
            'dni' => Auth::user()->dni
        ];

        return View::make('client.pages.edit_profile')
                        ->with('model', $userData)
//                        ->with('state', $state)
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    public function updateEmail($id) {

        if ($id != Auth::id()) {
            return Redirect::back();
        }

        //Campos
        $data = Input::only('email');

        //Reglas de validación
        $rules = ['email' => 'required|email|unique:users'];

        //Mensajes de error
        $messages = [
            'email.required' => 'Formato de email incorrecto.',
            'email.email' => 'Formato de email incorrecto.',
            'email.unique' => 'El email es el mismo o ya existe otro usuario con ese email.'];

        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'edit_profile')
                            ->withInput($data);
        }

        $this->user->setChangeEmail(Auth::id(), Input::get('email'));

        //Se envía el email
        Mail::send('emails.update_email', ['id' => Auth::id(), 'change_email_code' => Auth::user()->change_email_code], function($message) {
            $message->to(Auth::user()->email)->subject('Confirmación de cambio de correo electrónico');
        });

        return Redirect::back()
                        ->with('save_success', 'Se ha enviado un email para confirmar el cambio de email.');
    }

    public function updatePassword($id) {

        if ($id != Auth::id()) {
            return Redirect::back();
        }

        //Campos
        $data = Input::only('password');

        //Reglas de validación
        $rules = ['password' => 'required|alpha_dash|min:6'];

        //Mensajes de error
        $messages = [
            'password.alpha_dash' => 'Solo se admiten letras, números, guiones bajos y barras.',
            'password.required' => 'La contraseña ha de tener al menos 6 caracteres.',
            'password.min' => 'La contraseña ha de tener al menos 6 caracteres.'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'edit_profile')
                            ->withInput($data);
        }

        $this->user->setChangePassword(Auth::id(), Hash::make(Input::get('password')));

        //Se envía el email
        Mail::send('emails.update_password', ['id' => Auth::id(), 'change_password_code' => Auth::user()->change_password_code], function($message) {
            $message->to(Auth::user()->email)->subject('Confirmación de cambio de contraseña');
        });

        return Redirect::back()
                        ->with('save_success', 'Se ha enviado un email para confirmar el cambio de contraseña.');
    }

    public function updatePersonal($id) {

        if ($id != Auth::id()) {
            return Redirect::back();
        }

        //Campos
        $data = Input::only(['name', 'surname', 'birthdate', 'dni']);

        //Reglas de validación
        $rules = ['date' => 'date'];

        //Mensajes de error
        $messages = [
            'birthdate.date' => 'Fecha incorrecta'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules, $messages);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'edit_profile')
                            ->withInput($data);
        }

        if ($data['birthdate'] > 0) {
            $data['birthdate'] = new DateTime($data['birthdate']);
        }

        $this->user->updateById(Auth::id(), $data);

        return Redirect::back()
                        ->with('save_success', 'Los datos personales se han modificado correctamente.');
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
                        ->with('save_success', 'Se ha enviado un email para confirmar la baja.');
    }

    public function confirm($id, $confirmationCode) {

        $user = $this->user->getById($id);

        if (!$user || !$confirmationCode || $user->confirmation_code !== $confirmationCode) {
            return Redirect::route('info')
                            ->withErrors(['errorWithCode' => 'Error de confirmación'], 'confirm');
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
                        ->with('message', 'El cambio de email se ha confirmado.');
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
                        ->with('message', 'El cambio de contraseña se ha confirmado.');
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
