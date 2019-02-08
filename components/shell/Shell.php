<?php

namespace app\components\shell;

use yii\console\ExitCode;

/**
 * Class Shell
 * CLI support class
 * @package app\components\shell
 */
class Shell
{
    /** @var Shell */
    private static $instance;

    /**
     * Private Shell constructor (disable instantiating from outside).
     */
    private function __construct()
    {
    }

    /**
     * @return Shell
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Shell();
        }
        return self::$instance;
    }

    /**
     * Execute shell command
     * @param Command $command
     * @return mixed
     */
    public function exec(Command &$command)
    {
        \Yii::debug('Executing shell command ' . $command->toString());
        exec($command->toString(), $command->output, $returnValue);
        if ($returnValue != ExitCode::OK) {
            \Yii::debug('Error while execution, output: ' . $command->outputToString());
        }
        return $returnValue;
    }
}
