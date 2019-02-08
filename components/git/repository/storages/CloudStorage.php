<?php

namespace app\components\git\repository\storages;

use app\components\git\Commit;
use app\components\git\repository\storage;
use GuzzleHttp\Client;

/**
 * Class CloudStorage
 * @package app\components\git\repository\storages
 */
class CloudStorage extends Storage
{
    private $author;
    private $repository;

    const GIT_API_URL = 'https://api.github.com/repos/{author}/{repository}/commits';

    function __construct($repositoryUrl, array $config = [])
    {
        $this->author = $this->extractAuthor($repositoryUrl);
        $this->repository = $this->extractRepository($repositoryUrl);
        parent::__construct($config);
    }

    public function repositoryStored($uniqueId)
    {
        return true;
    }

    public function cloneRepository($repositoryUrl, $uniqueId)
    {
        return true;
    }

    public function getCommits($uniqueId, $limit = null, $offset = null)
    {
        $result = [];
        foreach ($this->getDataFromApi($limit, $offset) as $dataElement) {
            $result[] = new Commit([
                'hash' => $dataElement['sha'],
                'dateTime' => $dataElement['commit']['author']['date'],
                'email' => $dataElement['commit']['author']['email'],
                'name' => $dataElement['commit']['author']['name'],
                'subject' => explode(PHP_EOL, $dataElement['commit']['message'])[0],
                'body' => $dataElement['commit']['message'],
                'stat' => $dataElement['commit']['message']
            ]);
        }
        return $result;
    }

    private function getDataFromApi($limit, $offset)
    {
        return array_slice(
            json_decode($this->createHttpClient()->get($this->getApiCommitsUrl())->getBody(), true),
            $offset,
            $limit
        );
    }

    private function createHttpClient()
    {
        $client = new Client([
            'timeout' => DEFAULT_GIT_COMMITS_API_TIME_LIMIT,
        ]);
        return $client;
    }

    private function extractRepository($repositoryUrl)
    {
        return $this->getRepositoryUrlValuablePart($repositoryUrl, 1);
    }

    private function extractAuthor($repositoryUrl)
    {
        return $this->getRepositoryUrlValuablePart($repositoryUrl, 0);
    }

    private function getRepositoryUrlValuablePart($repositoryUrl, $index)
    {
        return explode('/', str_replace(['https://github.com/', '.git'], '', $repositoryUrl))[$index];
    }

    private function getApiCommitsUrl()
    {
        return str_replace(
            ['{author}', '{repository}'],
            [$this->author, $this->repository],
            static::GIT_API_URL
        );
    }
}
