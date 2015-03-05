<?php

namespace Repositories\Agerate;

/**
 *
 * @author Ivan
 */
interface AgerateRepositoryInterface {

    public function find($id);
    
    public function create($data);

    public function erase($id);

    public function update($id, $data);

    public function getByName($name);
}
