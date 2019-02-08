<?php

namespace app\components\shell;

use yii\base\BaseObject;
use yii\debug\models\search\Log;
use yii\log\Logger;

class Shell extends BaseObject
{
    public static function exec(Command &$command)
    {
        \Yii::debug('Executing shell command ' . $command->toString());
        exec($command->toString(), $output, $return);
        $command->output = implode(PHP_EOL, $output);
        return $return;
    }
}
