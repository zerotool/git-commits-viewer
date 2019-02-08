<?php

namespace app\components\git\repository;

use yii\base\BaseObject;

/**
 * Class Storage
 * @package app\components\git\repository
 */
abstract class Storage extends BaseObject
{
    /**
     * @param string $uniqueId
     * @return mixed
     */
    abstract function repositoryStored($uniqueId);

    /**
     * @param string $repositoryUrl
     * @param string $uniqueId
     * @return mixed
     */
    abstract function cloneRepository($repositoryUrl, $uniqueId);

    /**
     * @param $uniqueId
     * @param null|int $limit
     * @param null|int $offset
     * @return mixed
     */
    abstract function getCommits($uniqueId, $limit = null, $offset = null);
}
