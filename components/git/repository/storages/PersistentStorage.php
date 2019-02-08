<?php

namespace app\components\git\repository\storages;

use app\components\git\repository\storage;
use yii\db\Exception;

/**
 * @TODO: implement DB-related persistent storage
 * Class PersistentStorage
 * @package app\components\git\repository\storages
 */
class PersistentStorage extends Storage
{

    public function repositoryStored($uniqueId)
    {
        throw new Exception("Not yet implemented");
    }

    public function cloneRepository($repositoryUrl, $uniqueId)
    {
        throw new Exception("Not yet implemented");

    }

    public function getCommits($uniqueId, $limit = null, $offset = null)
    {
        throw new Exception("Not yet implemented");
    }
}
