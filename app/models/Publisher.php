<?php

/**
 * Description of Publisher
 *
 * @author Ivan
 */
class Publisher extends Eloquent{

    protected $fillable = ['name'];
    
    public function products() {
        return $this->hasMany('Product');
    }

}
