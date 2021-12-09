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
    const MOVE_POSITION_TO_NEXT_LINE_START_AT_PREVIOUS_CELL = 2;
    const MOVE_POSITION_TO_NEXT_LINE_START_AT_SIDEMARGIN = 1;
    const MOVE_POSITION_TO_THE_RIGHT = 0;

    private PDF $pdf;
    public float $width;
    public float $height;
    public string $align;
    public string $border;
    public int $newPosition;
    public bool $fill;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;

        $this->resetToDefault();
    }

    public function resetToDefault(): void
    {
        $this->align   = static::ALIGN_LEFT;
        $this->border  = static::NO_BORDER;
        $this->newPosition = static::MOVE_POSITION_TO_THE_RIGHT;
        $this->fill    = false;
        $this->height  = 0;
        $this->width   = 0;
    }

    public function create($value, $width = null, $newPosition = null): void
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

    public function createMulticell($value, $width = null): void
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
