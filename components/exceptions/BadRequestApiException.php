<?php

namespace app\components\exceptions;

use yii\web\BadRequestHttpException;

class BadRequestApiException extends BadRequestHttpException
{

    public $errors;

    function __construct($errors = [], ?string $message = null, int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        $result = [];
        foreach ($this->errors as $fieldName => $fieldErrors) {
            $result[] = implode(', ', $fieldErrors);
        }
        return $result;
    }
}
