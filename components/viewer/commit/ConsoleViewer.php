<?php

namespace app\components\viewer\commit;

use app\components\exceptions\UnsupportedCommitRenderModeException;
use app\components\viewer\Viewer;

class ConsoleViewer extends Viewer
{
    const RENDER_MODE_MUTE = 'mute';

    public function render()
    {
        try {
            return parent::render();
        } catch (UnsupportedCommitRenderModeException $e) {
            switch ($this->renderMode) {
                case static::RENDER_MODE_MUTE:
                    return '';
                    break;
                default:
                    throw new UnsupportedCommitRenderModeException('Unsupported render mode: ' . $this->renderMode);
                    break;
            }
        }
    }
}
