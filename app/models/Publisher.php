<?php

/**
 * Description of Publisher
 *
 * @author Ivan
 */
class Publisher extends Eloquent{

    public function products() {
        return $this->hasMany('Product');
    }

}
