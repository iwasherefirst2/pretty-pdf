<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\PartialInterface;
use Closure;

class SetTaxNumber implements PartialInterface
{
    /**
     * Add infobox in the top right corner of invoice
     * @return Closure
     */
    public static function getFunction(): Closure
    {
        return function (string $taxNumber) {
            $this->SetFont('DejaVuSansCondensed', '', 11);

            $x_pos = ($this->w) * 0.5 + ($this->w)*0.5 * 2/3;

            $this->SetXY($x_pos, 75);

            $this->SetTextColor(40, 40, 40);
            
            $this->Cell(($this->w)*0.5 * 1/3, 5, $this->words['Tax-Number'] . ':', 0, 0);

            $this->SetXY($x_pos, 80);

            $this->SetFont('DejaVuSansCondensed', 'B', 11);

            $this->SetTextColor(0, 0, 0);

            $this->MultiCell(($this->w)*0.5 * 1/3, 5, $taxNumber, 0, 'L');
        };
    }
}
