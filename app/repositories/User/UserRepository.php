<?php

namespace Repositories\User;

use \User as User;
use \Hash as Hash;

/**
 * Description of UserRepository
 *
 * @author Ivan
 */
class UserRepository implements UserRepositoryInterface {

    public function create($email, $password) {

        //Se crea el usuario
        $user = new User;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->confirmed = false;
        $user->confirmation_code = str_random(30);

        return $user->save();
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
