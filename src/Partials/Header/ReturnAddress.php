<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\ParcialInterface;

class ReturnAddress implements ParcialInterface
{
    /**
     * Add infobox in the top right corner of invoice
     * @return Closure
     */
    public static function getFunction(): \Closure
    {
        return function (string $address) {
            $this->SetTextColor(0, 136, 204);
            
            $this->SetXY($this->sideMargin, 51);

            $this->SetFont('DejaVuSansCondensed', '', 7);

            $this->Cell(100, 10, $address, 0, 1);
        };
    }
}
