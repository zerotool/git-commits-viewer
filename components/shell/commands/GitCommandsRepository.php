<?php

namespace app\components\shell\Commands;

use app\components\shell\Command;
use yii\base\BaseObject;

class GitCommandsRepository extends BaseObject
{
    public static function gitClone($repositoryUrl, $locaPath)
    {
        return new Command("git clone $repositoryUrl -q --bare --single-branch " . $locaPath);
    }

    public static function gitLog($localPath, $format, $limit = null, $offset = null)
    {
        return new Command("cd $localPath ; git log --stat --pretty=\"format:$format\" -n $limit --skip=$offset");
    }
}
