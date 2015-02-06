<?php

/**
 * Description of Language
 *
 * @author Ivan
 */
class Language extends Eloquent{
    
    public function products() {
        return $this->belongsToMany('Product')->withPivot('type');
    }
    
}
