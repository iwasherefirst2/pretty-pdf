<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;

class TaxNumber extends Drawable
{
    /**
     * @var string
     */
    private $taxNumber;

    public function set(string $taxNumber)
    {
        $this->taxNumber = $taxNumber;
    }
    
    /**
     * Add infobox in the top right corner of invoice
     */
    public function draw()
    {
        $this->setFont('DejaVuSansCondensed', '', 11);

        $x_pos = ($this->documentWidth) * 0.5 + ($this->documentWidth)*0.5 * 2/3;

        $this->setXY($x_pos, 75);

        $this->setTextColor(40, 40, 40);
            
        $this->cell(($this->documentWidth)*0.5 * 1/3, 5, $this->words['Tax-Number'] . ':');

        $this->setXY($x_pos, 80);

        $this->setFont('DejaVuSansCondensed', 'B', 11);

        $this->setTextColor(0, 0, 0);

        $this->multiCell(($this->documentWidth)*0.5 * 1/3, 5, $this->taxNumber);
    }
}
