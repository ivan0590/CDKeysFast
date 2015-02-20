<?php

namespace Repositories\Platform;

use \Platform as Platform;

/**
 * Description of PlatformRepository
 *
 * @author Ivan
 */
class PlatformRepository implements PlatformRepositoryInterface {

    public function exists($id) {
        return !Platform::where('id', '=', $id)->get()->isEmpty();
    }

    public function find($id) {
        return Platform::find($id);
    }

}
