<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Partials\Drawable;
use PrettyPdf\PDF;

class ReceiverAddress extends Drawable
{
    private $cellWidth;

    /**
     * @var array
     */
    private $address;

    public function set(array $address)
    {
        $this->address = $address;
    }
    
    /**
     * Add infobox in the top right corner of invoice
     */
    public function draw(): void
    {
        $this->SetTextColor(0, 0, 0);

        $this->SetFont('DejaVuSansCondensed', '', 11);

        $this->SetXY($this->leftMargin, 61);

        $this->cellWidth = $this->documentWidth*0.5 - $this->leftMargin;

        $height = $this->getLineHeight();
        
        foreach ($this->address as $text) {
            $this->MultiCell($this->cellWidth, $height, $text);
        }
    }

    private function getLineHeight(): float
    {
        // Use dummy_pdf to compute the height so that address fits in envelope
        $pdf_dummy = new PDF();
        $pdf_dummy->AddFont('DejaVuSansCondensed', '', 'DejaVuSansCondensed.ttf', true);
        $pdf_dummy->AddPage();
        $pdf_dummy->SetFont('DejaVuSansCondensed', '', 11);
        $pdf_dummy->setY(0);

        if (count($this->address) >= 7) {
            $pdf_dummy->SetFont('DejaVuSansCondensed', '', 9);
        }

        foreach ($this->address as $text) {
            $pdf_dummy->MultiCell($this->cellWidth, 5, $text, 1, 'L');
        }

        $num_rows = $pdf_dummy->getY()/5;
        // Fit text to 25mm envelope space.
        return ($num_rows > 0) ? 25 / $num_rows : 25;
    }
}
