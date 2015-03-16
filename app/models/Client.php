<?php

/**
 * Description of Client
 *
 * @author Ivan
 */
class Client extends Eloquent {

    protected $table = 'users_clients';
    
    public function user() {
        return $this->morphOne('User', 'userable');
    }

}
