<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\PartialInterface;
use BeautyBill\PDF;
use Closure;

class ReceiverAddress implements PartialInterface
{
    /**
     * Add infobox in the top right corner of invoice
     * @return Closure
     */
    public static function getFunction(): Closure
    {
        return function (array $address) {
            $this->SetTextColor(0, 0, 0);

            $this->SetFont('DejaVuSansCondensed', '', 11);

            $this->SetXY($this->sideMargin, 61);

            $height = ReceiverAddress::getLineHeight($address, $this->w, $this->sideMargin);

            foreach ($address as $line) {
                $this->MultiCell(($this->w)*0.5 - $this->sideMargin, $height, $line, 0, 'L');
            }
        };
    }

    public static function getLineHeight(array $address, int $width, int $margin)
    {
        $pdf_dummy = new PDF();
        $pdf_dummy->AddFont('DejaVuSansCondensed', '', 'DejaVuSansCondensed.ttf', true);
        $pdf_dummy->AddPage();
        $pdf_dummy->SetFont('DejaVuSansCondensed', '', 11);
        $pdf_dummy->setY(0);

        // USe dummy_pdf to compute the height so that address fits in evenlope

        if (count($address) >= 7) {
            $pdf_dummy->SetFont('DejaVuSansCondensed', '', 9);
        }

        foreach ($address as $line) {
            $pdf_dummy->MultiCell(($width)*0.5 - $margin, 5, $line, 1, 'L');
        }

        $num_rows = $pdf_dummy->getY()/5;
        // Fit text to 25mm envelope space.
        $height   = ($num_rows > 0) ? 25 / $num_rows : 25;

        return $height;
    }
}
