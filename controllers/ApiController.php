<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class ApiController extends Controller
{

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        $this->response = \Yii::$app->getResponse();
        $this->request = \Yii::$app->getRequest();
        return parent::beforeAction($action);
    }

    protected function returnError($errorMessages, $statusCode)
    {
        $this->response->content = json_encode(['errors' => $errorMessages]);
        $this->response->statusCode = $statusCode;
    }
}
