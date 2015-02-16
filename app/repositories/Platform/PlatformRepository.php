<?php

namespace Repositories\Platform;

use \Platform as Platform;
use \Category as Category;

/**
 * Description of PlatformRepository
 *
 * @author Ivan
 */
class PlatformRepository implements PlatformRepositoryInterface {

    public function find($id) {
        return Platform::find($id);
    }

}
