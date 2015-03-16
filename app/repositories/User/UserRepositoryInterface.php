<?php

namespace Repositories\User;

/**
 *
 * @author Ivan
 */
interface UserRepositoryInterface {
    
    public function emailExists($email);
    
    public function emailConfirmed($id);
    
    public function getByEmail($email);
    
    public function getByConfirmationCode($confirmationCode);
    
    public function setChangeEmail($id, $email);
    
    public function setChangePassword ($id, $password);
    
    public function setUnsuscribe($id);
    
    public function confirm($id);
    
    public function confirmChangeEmail($id);
    
    public function confirmChangePassword($id);

    public function confirmUnsuscribe($id);
}
