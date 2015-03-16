<?php

/**
 * Description of Game
 *
 * @author Ivan
 */
class Game extends Eloquent {

    protected $fillable = ['name', 'description', 'thumbnail_image_path', 'offer_image_path', 'agerate_id', 'category_id'];

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
