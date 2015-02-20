<?php

namespace Repositories\User;

use \User as User;
use \Client as Client;
use \Admin as Admin;
use \Hash as Hash;

/**
 * Description of UserRepository
 *
 * @author Ivan
 */
class UserRepository implements UserRepositoryInterface {

    public function createClient($email, $password) {

        //Rol de cliente
        $client = new Client;
        $client->save();
        
        //Datos de perfil de usuario
        $user = new User;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->confirmed = false;
        $user->confirmation_code = str_random(30);

        //Se crea el usuario con el rol de cliente
        return $client->user()->save($user);
    }

    public function emailExists($email) {
        return !User::where('email', '=', $email)->get()->isEmpty();
    }

    public function emailConfirmed($email) {
        return User::where('email', '=', $email)->first()->confirmed;
    }

    public function getConfirmationCode($email) {
        return User::where('email', '=', $email)->first()->confirmation_code;
    }

    public function getByConfirmationCode($confirmationCode) {
        return User::where('confirmation_code', '=', $confirmationCode)->first();
    }

    public function confirmEmail($id) {

        $user = User::find($id);
        
        if(!$user){
            return false;
        }
        
        $user->confirmed = true;
        $user->confirmation_code = null;
        
        return $user->save();
    }

}
