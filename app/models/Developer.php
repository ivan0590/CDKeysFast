<?php

/**
 * Description of Developer
 *
 * @author Ivan
 */
class Developer extends Eloquent {
    
    public function products() {
        return $this->belongsToMany('Product');
    }
    
}
