<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Partials\Drawable;

class ReturnAddress extends Drawable
{
    /**
     * @var string
     */
    private $address;

    public function set(string $address): void
    {
        $this->address = $address;
    }
    
    /**
     * Add infobox in the top right corner of invoice
     */
    public function draw(): void
    {
        $this->SetTextColor(0, 136, 204);
            
        $this->SetXY($this->sideMargin, 51);

        $this->SetFont('DejaVuSansCondensed', '', 7);

        $this->Cell(100, 10, $this->address, 0, 1);
    }
}
