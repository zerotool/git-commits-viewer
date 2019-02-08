<?php

namespace app\controllers;

use app\components\exceptions\BadRequestApiException;
use app\components\viewer\commit\ApiViewer;
use app\models\CommitsListRequest;
use yii\web\ServerErrorHttpException;

/**
 * Class CommitsController
 * @package app\controllers
 */
class CommitsController extends ApiController
{
    public function actionList()
    {
        $this->response->format = \yii\web\Response::FORMAT_JSON;
        try {
            $commitsListRequest = new CommitsListRequest($this->request->getBodyParams());
            $this->response->content = $commitsListRequest->processUsingViewer(
                new ApiViewer(\yii\web\Response::FORMAT_JSON)
            );
        } catch (BadRequestApiException $exception) {
            $this->returnError($exception->errors, $exception->statusCode);
        } catch (\Exception $exception) {
            $exceptionMask = new ServerErrorHttpException();
            $this->returnError(['general' => [$exception->getMessage()]], $exceptionMask->statusCode);
            \Yii::error($exception->getMessage());
        }
    }
}
