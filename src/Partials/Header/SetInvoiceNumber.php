<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;

class SetInvoiceNumber extends Drawable
{
    /**
     * @var string
     */
    private $invoiceNumber;

    public function set(string $invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * Add infobox in the top right corner of invoice
     */
    public function draw(): void
    {
        $this->SetFont('DejaVuSansCondensed', '', 11);
            
        $x_pos = ($this->documentWidth) * 0.5 + ($this->documentWidth)*0.5 * 1/3;

        $this->setXY($x_pos, 75);

        $this->setTextColor(40, 40, 40);

        $this->cell(($this->documentWidth)*0.5 * 1/3, 5, $this->words['Invoice'] . ':');

        $this->setXY($x_pos, 80);

        $this->setFont('DejaVuSansCondensed', 'B', 11);

        $this->setTextColor(0, 0, 0);

        $this->multiCell(($this->documentWidth)*0.5 * 1/3, 5, $this->invoiceNumber);
    }
}
