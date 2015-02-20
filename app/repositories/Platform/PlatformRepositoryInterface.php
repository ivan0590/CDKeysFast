<?php

namespace Repositories\Platform;

/**
 *
 * @author Ivan
 */
interface PlatformRepositoryInterface {

    public function exists($id);
    
    public function find($id);
    
}
