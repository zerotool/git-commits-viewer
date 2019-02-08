<?php

namespace app\components\git\repository\storages;

use app\components\exceptions\FailedToCloneGitRepositoryException;
use app\components\exceptions\FailedToGetCommitsException;
use app\components\git\Commit;
use app\components\git\repository\storage;
use app\components\shell\Commands\GitCommandsRepository;
use yii\console\ExitCode;

class FolderStorage extends Storage
{
    const BASE_PATH = 'storage' . DIRECTORY_SEPARATOR . 'repositories';

    const COMMITS_SEPARATOR = '|commit|';
    const COMMIT_FIELDS_SEPARATOR = '|separator|';
    const COMMIT_FIELDS = [
        '%H' => 'hash',
        '%aI' => 'dateTime',
        '%aE' => 'email',
        '%cN' => 'name',
        '%b' => 'subject',
        '%B' => 'body',
        '%d' => 'stat'
    ];

    public function repositoryStored($uniqueId)
    {
        return file_exists($this->getLocalPath($uniqueId));
    }

    public function cloneRepository($repositoryUrl, $uniqueId)
    {
        if (!$this->repositoryStored($uniqueId)) {
            $cloneCommand = GitCommandsRepository::gitClone($repositoryUrl, $this->getLocalPath($uniqueId));
            if ($cloneCommand->exec() !== ExitCode::OK) {
                throw new FailedToCloneGitRepositoryException;
            } else {
                return $cloneCommand->output;
            }
        }
    }

    public function getCommits($uniqueId, $limit = null, $offset = null)
    {
        $getCommitsCommand = GitCommandsRepository::gitLog(
            $this->getLocalPath($uniqueId),
            $this->getCommitFormat(),
            $limit,
            $offset
        );
        if ($getCommitsCommand->exec() !== ExitCode::OK) {
            throw new FailedToGetCommitsException;
        }
        foreach (explode(static::COMMITS_SEPARATOR, $getCommitsCommand->output) as $commit) {
            $parts = explode(static::COMMIT_FIELDS_SEPARATOR, $commit);
            if (count($parts) == count(static::COMMIT_FIELDS)) {
                yield new Commit(array_combine(array_values(static::COMMIT_FIELDS), $parts));
            }
        }
    }

    private function getCommitFormat()
    {
        return static::COMMITS_SEPARATOR . implode(static::COMMIT_FIELDS_SEPARATOR, array_keys(static::COMMIT_FIELDS));
    }

    private function getLocalPath($uniqueId)
    {
        return implode(DIRECTORY_SEPARATOR, [\Yii::$app->basePath, self::BASE_PATH, $uniqueId]);
    }
}
