<?php

namespace Repositories\Admin;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \Admin as Admin;

/**
 * Description of AdminRepository
 *
 * @author Ivan
 */
class AdminRepository extends BaseRepository implements AdminRepositoryInterface {

    public function __construct(Admin $model) {
        $this->model = $model;
    }

}
