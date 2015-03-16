<?php

/**
 * Description of Platform
 *
 * @author Ivan
 */
class Platform extends Eloquent{

    protected $fillable = ['name', 'description', 'icon_path'];
    
    public function products() {
        return $this->hasMany('Product');
    }

}
