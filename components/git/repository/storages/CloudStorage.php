<?php

namespace app\components\git\repository\storages;

use app\components\git\repository\storage;

/**
 * @TODO: implement cloud storage (e.g. git ls-remote)
 * Class CloudStorage
 * @package app\components\git\repository\storages
 */
class CloudStorage extends Storage
{
    public function repositoryStored($uniqueId)
    {
        throw new \Exception("Not yet implemented");
    }

    public function cloneRepository($repositoryUrl, $uniqueId)
    {
        throw new \Exception("Not yet implemented");
    }

    public function getCommits($uniqueId, $limit = null, $offset = null)
    {
        throw new \Exception("Not yet implemented");
    }
}
