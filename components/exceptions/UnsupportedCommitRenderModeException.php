<?php

namespace app\components\exceptions;

use yii\base\Exception;

class UnsupportedCommitRenderModeException extends Exception
{
    protected $message = 'Unsupported commit render mode choosed';
}
