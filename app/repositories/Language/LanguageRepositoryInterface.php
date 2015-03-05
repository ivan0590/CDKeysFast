<?php

namespace Repositories\Language;

/**
 *
 * @author Ivan
 */
interface LanguageRepositoryInterface {

    public function find($id);
    
    public function create($data);

    public function erase($id);

    public function update($id, $data);

    public function getByName($name);
}
