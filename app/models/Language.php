<?php

/**
 * Description of Language
 *
 * @author Ivan
 */
class Language extends Eloquent{
    
    protected $fillable = ['name'];
    
    public function products() {
        return $this->belongsToMany('Product')->withPivot('type');
    }
    
}
