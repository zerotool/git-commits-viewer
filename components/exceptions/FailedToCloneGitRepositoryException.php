<?php

namespace app\components\exceptions;

use yii\base\Exception;

class FailedToCloneGitRepositoryException extends Exception
{
    protected $message = 'Failed to clone GIT repository';
}
