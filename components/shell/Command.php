<?php

namespace app\components\shell;

use yii\base\BaseObject;

/**
 * Class Command
 * @package app\components\shell
 */
class Command extends BaseObject
{
    private $command;
    public $output;

    const RESILIENT_MODE = ' 2>&1';

    public function __construct($command, array $config = [])
    {
        $this->command = $command;
        parent::__construct($config);
    }

    /**
     * @return mixed
     */
    public function exec()
    {
        return Shell::getInstance()->exec($this);
    }

    /**
     * @param string $linesSeparator
     * @return string
     */
    public function outputToString($linesSeparator = PHP_EOL)
    {
        return implode($linesSeparator, $this->output);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->command . static::RESILIENT_MODE;
    }
}
