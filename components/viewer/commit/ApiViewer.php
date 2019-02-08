<?php

namespace app\components\viewer\commit;

use app\components\exceptions\UnsupportedCommitRenderModeException;
use app\components\viewer\Viewer;

class ApiViewer extends Viewer
{
    public function render()
    {
        try {
            parent::render($this->renderMode);
        } catch (\Exception $e) {
            switch ($this->renderMode) {
                case \yii\web\Response::FORMAT_JSON:
                    return json_encode(['elements' => iterator_to_array($this->elements)]) . static::LINE_SEPARATOR;
                    break;
                default:
                    throw new UnsupportedCommitRenderModeException("Unsupported render mode: $this->renderMode");
                    break;
            }
        }
    }
}
