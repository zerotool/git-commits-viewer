<?php

namespace app\models;

use app\components\exceptions\BadRequestApiException;
use app\components\git\Repository;
use app\components\git\repository\storages\FolderStorage;
use app\components\viewer\Viewer;
use yii\base\Model;

class CommitsListRequest extends Model
{
    public $repositoryUrl = DEFAULT_REPOSITORY_URL;
    public $limit = DEFAULT_REPOSITORY_COMMITS_LIMIT;
    public $offset = DEFAULT_REPOSITORY_COMMITS_OFFSET;

    function __construct(array $config = [])
    {
        parent::__construct($config);
        if (!$this->validate()) {
            throw new BadRequestApiException($this->getErrors());
        }
    }

    public function rules()
    {
        return [
            [['repositoryUrl', 'limit', 'offset'], 'required'],
            ['limit', 'compare', 'compareValue' => MAX_REPOSITORY_COMMITS_LIMIT, 'operator' => '<=', 'type' => 'number'],
            ['repositoryUrl', 'url'],
        ];
    }

    public function processUsingViewer(Viewer $viewer)
    {
        return $viewer
            ->setElements($this->getCommits())
            ->render();
    }

    public function getCommits()
    {
        return $this->getRepository()->getCommits($this->limit, $this->offset);
    }

    private function getRepository()
    {
        return new Repository([
            'url' => $this->repositoryUrl,
            'storage' => new FolderStorage()
        ]);
    }
}
