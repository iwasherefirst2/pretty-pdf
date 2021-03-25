<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Partials\Drawable;
use PrettyPdf\PDF;

class ReceiverAddress extends Drawable
{
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

        $this->SetXY($this->sideMargin, 61);

        $height = $this->getLineHeight();
        
        foreach ($this->address as $line) {
            $this->MultiCell(($this->documentWidth)*0.5 - $this->sideMargin, $height, $line);
        }
    }

    private function getLineHeight(): float
    {
        $pdf_dummy = new PDF();
        $pdf_dummy->AddFont('DejaVuSansCondensed', '', 'DejaVuSansCondensed.ttf', true);
        $pdf_dummy->AddPage();
        $pdf_dummy->SetFont('DejaVuSansCondensed', '', 11);
        $pdf_dummy->setY(0);

        // Use dummy_pdf to compute the height so that address fits in envelope

        if (count($this->address) >= 7) {
            $pdf_dummy->SetFont('DejaVuSansCondensed', '', 9);
        }

        foreach ($this->address as $line) {
            $pdf_dummy->MultiCell(($this->documentWidth)*0.5 - $this->sideMargin, 5, $line, 1, 'L');
        }

        $num_rows = $pdf_dummy->getY()/5;
        // Fit text to 25mm envelope space.
        return ($num_rows > 0) ? 25 / $num_rows : 25;
    }
}
