<?php

namespace app\components\git;

use yii\base\BaseObject;

class Commit extends BaseObject
{
    public $hash;
    public $dateTime;
    public $email;
    public $name;
    public $subject;
    public $body;
    public $stat;

    public function toString()
    {
        return $this->hash . ':' . $this->dateTime;
    }
}
