<?php

namespace app\components\git;

use yii\base\BaseObject;
use app\components\git\repository\storage;

class Repository extends BaseObject
{
    /** @var [] */
    public $commits;

    /** @var string */
    public $url;

    /** @var Storage */
    public $storage;

    public function init()
    {
        parent::init();
        $this->storage->cloneRepository($this->url, $this->getUniqueId());
    }

    public function getUniqueId()
    {
        return sha1($this->url);
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getCommits($limit = null, $offset = null)
    {
        if ($this->commits === null) {
            $this->commits = $this->storage->getCommits($this->getUniqueId(), $limit, $offset);
        }
        return $this->commits;
    }
}
