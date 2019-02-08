<?php

namespace app\commands;

use app\components\exceptions\BadRequestApiException;
use app\components\viewer\commit\ConsoleViewer;
use app\models\CommitsListRequest;
use yii\console\Controller;
use yii\console\ExitCode;

class GitController extends Controller
{
    /**
     * This command echoes all commits for a given Git repository URL.
     * @param string $repositoryUrl URL of Git repository to view commits from. E.g. https://github.com/sebastianbergmann/phpunit.gi
     * @param int $commitsLimit Amount of commits to select
     * @param int $commitsOffset Amount of commits to skip
     * @param string $mode Modes: full, short, mute
     * @return int Exit code
     */
    public function actionLog(
        $repositoryUrl = DEFAULT_REPOSITORY_URL,
        $commitsLimit = DEFAULT_REPOSITORY_COMMITS_LIMIT,
        $commitsOffset = DEFAULT_REPOSITORY_COMMITS_OFFSET,
        $mode = ConsoleViewer::RENDER_MODE_SHORT
    ) {
        try {
            $commitsListRequest = new CommitsListRequest([
                'repositoryUrl' => $repositoryUrl,
                'limit' => $commitsLimit,
                'offset' => $commitsOffset
            ]);
            echo $commitsListRequest->processUsingViewer(new ConsoleViewer($mode));
            return ExitCode::OK;
        } catch (BadRequestApiException $exception) {
            echo 'Error: ' . implode(PHP_EOL, $exception->getErrorMessages()) . PHP_EOL;
            return ExitCode::DATAERR;
        } catch (\Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
            return ExitCode::DATAERR;
        }
    }
}
