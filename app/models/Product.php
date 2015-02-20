<?php

/**
 * Description of Product
 *
 * @author Ivan
 */
class Product extends Eloquent {

    public function game() {
        return $this->belongsTo('Game');
    }

    public function platform() {
        return $this->belongsTo('Platform');
    }

    public function languages() {
        return $this->belongsToMany('Language');
    }

    public function textLanguages() {
        return $this->belongsToMany('Language')->withPivot('type')->having('type', '=', 'text');
    }

    public function audioLanguages() {
        return $this->belongsToMany('Language')->withPivot('type')->having('type', '=', 'audio');
    }

    public function developers() {
        return $this->belongsToMany('Developer');
    }

    public function publisher() {
        return $this->belongsTo('Publisher');
    }

}
