<?php

/**
 * Description of Agerate
 *
 * @author Ivan
 */
class Agerate extends Eloquent {

    protected $fillable = ['name'];
    
    public function games() {
        return $this->hasMany('Game');
    }

}
