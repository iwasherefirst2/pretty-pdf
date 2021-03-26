<?php

namespace PrettyPdf\Builder;

use PrettyPdf\PDF;

class Cell
{
    const NO_BORDER = 0;

    const BORDER    = 1;

    const ALIGN_LEFT  = 'L';

    const ALIGN_RIGHT = 'R';

    const ALIGN_CENTER = 'C';

    const MOVE_POSITION_TO_NEXT_LINE_START_AT_SIDEMARGIN = 2;

    const MOVE_POSITION_TO_NEXT_LINE_START_AT_BOX = 1;

    const MOVE_POSITION_TO_THE_RIGHT = 0;

    /**
     * @var PDF
     */
    private $pdf;

    /**
     * @var float
     */
    public $width;

    /**
     * @var float
     */
    public $height;

    /**
     * @var string
     */
    public $align;

    /**
     * @var int;
     */
    public $border;

    /**
     * @var int
     */
    public $newPosition;

    /**
     * @var bool
     */
    public $fill;

    /**
     * Cell constructor.
     * @param PDF $pdf
     */
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;

        $this->resetToDefault();
    }

    public function resetToDefault()
    {
        $this->align   = static::ALIGN_LEFT;
        $this->border  = static::NO_BORDER;
        $this->newPosition = static::MOVE_POSITION_TO_THE_RIGHT;
        $this->fill    = false;
        $this->height  = 0;
        $this->width   = 0;
    }

    public function create($value, $width = null, $newPosition = null)
    {
        $this->pdf->cell(
            $width ?? $this->width,
            $this->height,
            $value,
            $this->border,
            $newPosition ?? $this->newPosition,
            $this->align,
            $this->fill
        );
    }

    public function createMulticell($value, $width = null)
    {
        $this->pdf->multiCell(
            $width ?? $this->width,
            $this->height,
            $value,
            $this->border,
            $this->align,
            $this->fill
        );
    }
}
