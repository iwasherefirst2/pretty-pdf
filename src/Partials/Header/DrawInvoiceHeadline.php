<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;

class DrawInvoiceHeadline extends Drawable
{
    public function draw(): void
    {
        $this->setFont('DejaVuSansCondensed', '', 38);
        $this->setXY(($this->documentWidth) * 0.5, 55);
        $this->cell(100, 10, strtoupper($this->words['Invoice']), 0, 1);
    }
}
