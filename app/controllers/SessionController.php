<?php

use Repositories\User\UserRepositoryInterface as UserRepositoryInterface;
use Services\Validation\Laravel\SessionValidator as SessionValidator;

class SessionController extends \BaseController {

    public function __construct(UserRepositoryInterface $user) {
        $this->user = $user;
    }

    /**
     * 
     *
     * @return Response
     */
    public function getLogin() {

        return View::make('client.pages.login');
    }

    /**
     * 
     *
     * @return Response
     */
    public function store() {

        //Campos del formulario
        $data = Input::only(['email', 'password']);

        //Validación de los campos del formulario
        $validator = new SessionValidator(App::make('validator'));

        //Los campos no son válidos
        if ($validator->with($data)->passes()) {
            
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
                            Redirect::route('admin.product.index') : //Admin
                            Redirect::back(); //Cliente
                }
            }

            //No existe usuario con esas credenciales 
            return Redirect::back()
                            ->withErrors(['userNotExists' => 'El email o la contraseña son incorrectos.'], 'login')
                            ->withInput(Input::except('password'));
        }
        
        return Redirect::back()
                        ->withErrors($validator->errors(), 'login')
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
