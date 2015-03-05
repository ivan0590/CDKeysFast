<?php

namespace Repositories\User;

use \User as User;
use \Client as Client;
use \Admin as Admin;
use \Hash as Hash;
use \DateTime as DateTime;

/**
 * Description of UserRepository
 *
 * @author Ivan
 */
class UserRepository implements UserRepositoryInterface {

    public function create($email, $password, $role) {

        if ($role !== 'client' && $role !== 'admin') {
            throw new InvalidArgumentException('El rol ha de ser "admin" o "client"');
        }

        if ($role === 'admin') {
            $userRole = new Admin;
        } else {
            $userRole = new Client;
        }

        //Rol
        $userRole->save();

        //Datos de perfil de usuario
        $user = new User;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->confirmed = false;
        $user->confirmation_code = str_random(30);
        $user->change_email_code = '';
        $user->change_email = null;
        $user->change_password_code = '';
        $user->change_password = '';
        $user->unsuscribe_code = '';

        //Se crea el usuario con el rol de cliente
        return $userRole->user()->save($user);
    }

    public function updateAdminPersonalData($id, $name, $surname) {
        
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->name = $name;
        $user->surname = $surname;

        return $user->save();
    }

    public function updateClientPersonalData($id, $name, $surname, $birthdate, $dni) {

        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->name = $name;
        $user->surname = $surname;
        $user->userable->birthdate = new DateTime($birthdate);
        $user->userable->dni = $dni;

        return $user->save() && $user->userable->save();
    }

    public function emailExists($email) {
        return !User::where('email', '=', $email)->get()->isEmpty();
    }

    public function emailConfirmed($email) {
        return User::where('email', '=', $email)->first()->confirmed;
    }

    public function getById($id) {
        return User::where('id', '=', $id)->first();
    }

    public function getByEmail($email) {
        return User::where('email', '=', $email)->first();
    }

    public function getByConfirmationCode($confirmationCode) {
        return User::where('confirmation_code', '=', $confirmationCode)->first();
    }

    public function confirm($id) {

        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->confirmed = true;
        $user->confirmation_code = null;

        return $user->save();
    }

    public function setChangeEmail($id, $email) {

        $user = User::find($id);

        if (!$user || !$email) {
            return false;
        }

        $user->change_email_code = str_random(30);
        $user->change_email = $email;

        return $user->save();
    }

    public function setChangePassword($id, $password) {

        $user = User::find($id);

        if (!$user || !$password) {
            return false;
        }

        $user->change_password_code = str_random(30);
        $user->change_password = $password;

        return $user->save();
    }

    public function setUnsuscribe($id) {

        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->unsuscribe_code = str_random(30);

        return $user->save();
    }

    public function confirmChangeEmail($id) {

        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->email = $user->change_email;
        $user->change_email = null;
        $user->change_email_code = null;

        return $user->save();
    }

    public function confirmChangePassword($id) {

        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->password = $user->change_password;
        $user->change_password = null;
        $user->change_password_code = null;

        return $user->save();
    }

    public function confirmUnsuscribe($id) {

        $user = User::find($id);

        if (!$user) {
            return false;
        }

        return $user->userable->delete() && $user->delete();
    }

}
