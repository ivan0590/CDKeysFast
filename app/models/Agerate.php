<?php

/**
 * Description of Agerate
 *
 * @author Ivan
 */
class Agerate extends Eloquent {

    public function games() {
        return $this->hasMany('Game');
    }

}
