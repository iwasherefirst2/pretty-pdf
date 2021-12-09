<?php

namespace PrettyPdf\Partials\Letter;

use PrettyPdf\Builder\Cell;
use PrettyPdf\Partials\Drawable;

class Text extends Drawable
{
    private string $text;

    public function set(string $text): void
    {
        $this->text = $text;
    }

    public function draw(): void
    {
        $this->setY(121 + 5 + 5);
        $this->setPlainFontSize(12);

        $this->MultiCell(
            $width = 0,
            $height = 5,
            $this->text,
            Cell::NO_BORDER,
            Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_SIDEMARGIN
        );
    }
}
