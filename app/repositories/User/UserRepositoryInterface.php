<?php

namespace Repositories\User;

/**
 *
 * @author Ivan
 */
interface UserRepositoryInterface {
    
    public function createClient($email, $password);
    
    public function emailExists($email);
    
    public function emailConfirmed($id);
    
    public function getConfirmationCode($email);
    
    public function getByConfirmationCode($confirmationCode);
    
    public function confirmEmail($id);
    
}
