<?php

namespace PrettyPdf\Partials\Letter;

use PrettyPdf\Builder\Cell;
use PrettyPdf\Partials\Drawable;

class Date extends Drawable
{
    /**
     * @var string|null
     */
    private $date;

    /**
     * @var bool
     */
    private $up;

    public function set(string $date = null, bool $up = false)
    {
        $this->up = $up;
        $this->date = $date;
    }

    public function draw(): void
    {
        $this->setPlainFontSize(12);

        $height = ($this->up) ? 55 : 121;

        $this->setXY($this->documentWidth*2/3 + $this->leftMargin, $height);
        //$this->documentWidth*2/3

        $this->Cell(
            $this->documentWidth* 1/3,
            5,
            $this->words['Date'] . ':',
            Cell::NO_BORDER,
            Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_PREVIOUS_CELL
        );

        $this->setBoldFontSize(12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell($this->documentWidth*0.5 * 1/3, 5, $this->date ?? date('d/m/Y'), Cell::NO_BORDER, Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_SIDEMARGIN);
    }
}
