<?php

namespace Repositories\User;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \User as User;

/**
 * Description of UserRepository
 *
 * @author Ivan
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface {

    public function __construct(User $model) {
        $this->model = $model;
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
