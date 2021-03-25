<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;
use BeautyBill\Traits\InvoiceBoxable;

class InvoiceNumber extends Drawable
{
    use InvoiceBoxable;
    
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
        $this->addInvoiceBoxEntry(2, $this->invoiceNumber, $this->words['Invoice']);
    }
}
