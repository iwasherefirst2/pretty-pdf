<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;
use BeautyBill\Traits\InvoiceBoxable;

class Date extends Drawable
{
    use InvoiceBoxable;

    /**
     * @var int|null
     */
    private $timestamp;

    public function set(int $timestamp = null)
    {
        $this->timestamp = $timestamp;
    }
    
    /**
     * Add infobox in the top right corner of invoice
     */
    public function draw(): void
    {
        $this->addInvoiceBoxEntry(1, $this->getDate(), $this->words['Date']);
    }
    
    private function getDate()
    {
        if (strtolower($this->lang) == 'en') {
            return date('d M Y', $this->timestamp);
        }
        
        return date('d/m/Y', $this->timestamp);
    }
}
