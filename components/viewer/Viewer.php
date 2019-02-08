<?php

namespace app\components\viewer;

use app\components\exceptions\UnsupportedCommitRenderModeException;
use yii\base\BaseObject;

/**
 * Class Viewer (Composite)
 * @package app\components\viewer
 */
class Viewer extends BaseObject
{
    public $elements;
    public $renderMode;

    const RENDER_MODE_FULL = 'full';
    const RENDER_MODE_SHORT = 'short';

    const LINE_SEPARATOR = PHP_EOL;

    function __construct($renderMode, array $config = [])
    {
        parent::__construct($config);
        $this->renderMode = $renderMode;
    }

    /**
     * @param $elements
     * @return $this
     */
    public function setElements($elements)
    {
        $this->elements = $elements;
        return $this;
    }

    /**
     * @return string
     * @throws UnsupportedCommitRenderModeException
     */
    public function render()
    {
        switch ($this->renderMode) {
            case static::RENDER_MODE_FULL:
                return $this->wrapOutput($this->renderFull());
                break;
            case static::RENDER_MODE_SHORT:
                return $this->wrapOutput($this->renderShort());
                break;
            default:
                throw new UnsupportedCommitRenderModeException('Unsupported render mode: ' . $this->renderMode);
                break;
        }
    }

    /**
     * @return array
     */
    private function renderShort()
    {
        $result = [];
        foreach ($this->elements as $element) {
            $result[] = $element->toString();
        }
        return $result;
    }

    /**
     * @return array
     */
    private function renderFull()
    {
        $result = [];
        foreach ($this->elements as $element) {
            $result[] = print_r($element, true);
        }
        return $result;
    }

    /**
     * @param $outputArray
     * @return string
     */
    private function wrapOutput($outputArray)
    {
        return implode(static::LINE_SEPARATOR, $outputArray) . static::LINE_SEPARATOR;
    }
}
