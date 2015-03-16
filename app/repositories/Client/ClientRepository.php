<?php

namespace Repositories\Client;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \Client as Client;

/**
 * Description of ClientRepository
 *
 * @author Ivan
 */
class ClientRepository extends BaseRepository implements ClientRepositoryInterface {

    public function __construct(Client $model) {
        $this->model = $model;
    }

}
