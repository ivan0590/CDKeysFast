<?php

/**
 * Description of Category
 *
 * @author Ivan
 */
class Category extends Eloquent{
    
    public function games(){
        return $this->hasMany('Game');
    }
    
}
