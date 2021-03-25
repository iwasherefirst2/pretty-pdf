<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;
use BeautyBill\Traits\InvoiceBoxable;

class TaxNumber extends Drawable
{
    use InvoiceBoxable;

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
        $this->addInvoiceBoxEntry(3, $this->taxNumber, $this->words['Tax-Number']);
    }
}
