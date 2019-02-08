<?php

namespace app\components\shell;

use yii\base\BaseObject;

class Command extends BaseObject
{
    private $command;
    public $output;

    public function __construct($command, array $config = [])
    {
        $this->command = $command;
        parent::__construct($config);
    }

    public function exec()
    {
        return Shell::exec($this);
    }

    public function toString()
    {
        return $this->command . " 2>&1";
    }
}
