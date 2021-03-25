<?php

namespace BeautyBill\Traits;

trait InvoiceBoxable
{
    protected function addInvoiceBoxEntry(int $position, string $value, string $label)
    {
        $this->SetFont('DejaVuSansCondensed', '', 11);

        $x_pos = ($this->documentWidth) * 0.5 * (1 + ($position-1)/3);

        $this->setXY($x_pos, 75);

        $this->setTextColor(40, 40, 40);

        $this->cell(($this->documentWidth)*0.5 * 1/3, 5, $label . ':');

        $this->setXY($x_pos, 80);

        $this->setFont('DejaVuSansCondensed', 'B', 11);

        $this->setTextColor(0, 0, 0);

        $this->multiCell(($this->documentWidth)*0.5 * 1/3, 5, $value);
    }
}
