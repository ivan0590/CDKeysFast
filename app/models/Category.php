<?php

/**
 * Description of Category
 *
 * @author Ivan
 */
class Category extends Eloquent{
    
    protected $fillable = ['name', 'description'];
    
    public function games(){
        return $this->hasMany('Game');
    }
    
}
