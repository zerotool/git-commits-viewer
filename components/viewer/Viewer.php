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

    public function setElements($elements)
    {
        $this->elements = $elements;
        return $this;
    }

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
                throw new UnsupportedCommitRenderModeException("Unsupported render mode: $this->renderMode");
                break;
        }
    }

    private function renderShort()
    {
        foreach ($this->elements as $element) {
            yield $element->toString();
        }
    }

    private function renderFull()
    {
        foreach ($this->elements as $element) {
            yield print_r($element, true);
        }
    }

    private function wrapOutput($outputIterator)
    {
        return implode(static::LINE_SEPARATOR, iterator_to_array($outputIterator)) . static::LINE_SEPARATOR;
    }
}
