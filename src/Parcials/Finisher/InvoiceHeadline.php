<?php

namespace BeautyBill\Parcials\Finisher;

use BeautyBill\Parcials\ParcialInterface;

class InvoiceHeadline implements ParcialInterface
{
    /**
     * Draw line below logo and header infobox
     * @return Closure
     */
    public static function getFunction(): \Closure
    {
        return function () {
            $this->SetFont('DejaVuSansCondensed', '', 38);
            $this->SetXY(($this->w) * 0.5, 55);
            $this->Cell(100, 10, strtoupper($this->words['Invoice']), 0, 1);
        };
    }
}
