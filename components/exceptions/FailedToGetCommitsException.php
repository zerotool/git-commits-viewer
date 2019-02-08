<?php

namespace app\components\exceptions;

use yii\base\Exception;

class FailedToGetCommitsException extends Exception
{
    protected $message = 'Failed to get GIT commits';
}
