<?php

/**
 * Description of Developer
 *
 * @author Ivan
 */
class Developer extends Eloquent {

    protected $fillable = ['name'];
    
    public function products() {
        return $this->belongsToMany('Product');
    }
    
}
