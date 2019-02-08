<?php

namespace app\components\git\repository;

use yii\base\BaseObject;

abstract class Storage extends BaseObject
{
    abstract function repositoryStored($uniqueId);

    abstract function cloneRepository($repositoryUrl, $uniqueId);

    abstract function getCommits($uniqueId, $limit = null, $offset = null);
}
