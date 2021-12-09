<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Builder\Cell;
use PrettyPdf\Partials\Drawable;

/**
 * Class ReturnAddress
 *
 * Creates return address right about
 * the address of receipent
 *
 * @package PrettyPdf\Partials\Header
 */
class ReturnAddress extends Drawable
{
    private string $address;

    public function set(string $address): void
    {
        $this->address = $address;
    }

    public function draw(): void
    {
        $this->SetTextColor(0, 136, 204);
            
        $this->SetXY($this->leftMargin, 51);

        $this->SetFont('DejaVuSansCondensed', '', 7);

        $this->Cell(
            $width = 100,
            $height = 10,
            $this->address,
            Cell::NO_BORDER,
            CELL::MOVE_POSITION_TO_NEXT_LINE_START_AT_SIDEMARGIN
        );
    }
}
