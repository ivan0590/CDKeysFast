<?php

/**
 * Description of Platform
 *
 * @author Ivan
 */
class Platform extends Eloquent{
    
    public function products() {
        return $this->hasMany('Product');
    }
    
}
