<?php

/**
 * Description of Game
 *
 * @author Ivan
 */
class Game extends Eloquent {

    public function products() {
        return $this->hasMany('Product');
    }

    public function agerate() {
        return $this->belongsTo('Agerate');
    }
    
    public function category() {
        return $this->belongsTo('Category');
    }
}
