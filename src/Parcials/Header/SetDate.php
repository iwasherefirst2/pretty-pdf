<?php

namespace BeautyBill\Parcials\Header;

use BeautyBill\Parcials\ParcialInterface;

class SetDate implements ParcialInterface
{
    /**
     * Add infobox in the top right corner of invoice
     * @return Closure
     */
    public static function getFunction(): \Closure
    {
        return function (int $timestamp = null) {
            $this->SetFont('DejaVuSansCondensed', '', 11);
            
            $this->SetXY(($this->w) * 0.5, 75);

            $this->SetTextColor(40, 40, 40);

            $this->Cell(($this->w)*0.5 * 1/3, 5, $this->words['Date'] . ':', 0, 0);

            if (strtolower($this->lang) == 'en') {
                $datum = date('d M Y', $timestamp);
            } else {
                $datum = date('d/m/Y', $timestamp);
            }

            $this->SetXY(($this->w)*0.5, 80);

            $this->SetFont('DejaVuSansCondensed', 'B', 11);

            $this->SetTextColor(0, 0, 0);

            $this->MultiCell(($this->w)*0.5 * 1/3, 5, $datum, 0, 'L');
        };
    }
}
