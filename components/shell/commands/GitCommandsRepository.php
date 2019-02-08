<?php

namespace app\components\shell\Commands;

use app\components\shell\Command;
use yii\base\BaseObject;

/**
 * Class GitCommandsRepository
 * @package app\components\shell\Commands
 */
class GitCommandsRepository extends BaseObject
{
    /**
     * @param $repositoryUrl
     * @param $locaPath
     * @return Command
     */
    public static function gitClone($repositoryUrl, $locaPath)
    {
        return new Command("git clone $repositoryUrl -q --bare --single-branch $locaPath");
    }

    /**
     * @param $localPath
     * @param $format
     * @param null $limit
     * @param null $offset
     * @return Command
     */
    public static function gitLog($localPath, $format, $limit = null, $offset = null)
    {
        return new Command("cd $localPath ; git log --stat --pretty=\"format:$format\" -n $limit --skip=$offset");
    }
}
