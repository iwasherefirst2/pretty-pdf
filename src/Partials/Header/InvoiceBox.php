<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Partials\Drawable;

class InvoiceBox extends Drawable
{
    /**
     * @var array
     */
    private $data;
    
    private $position = 0;

    /**
     * @var string|null
     */
    private $headline;

    public function set(array $data, $headline = null)
    {
        $this->data = $data;
        
        $this->headline = $headline;
    }
    
    public function draw(): void
    {
        $this->addInvoiceHeadline();
        
        foreach ($this->data as $label => $value) {
            $this->addInvoiceBoxEntry($label, $value);
        }
    }
    
    private function addInvoiceHeadline()
    {
        $this->setFont('DejaVuSansCondensed', '', 38);
        $this->setXY(($this->documentWidth) * 0.5, 55);
        $this->cell(100, 10, strtoupper($this->headline ?? $this->words['Invoice']), 0, 1);
    }

    private function addInvoiceBoxEntry(string $label, string $value)
    {
        if ($label == 'Date' && $value == 'Today') {
            $value = $this->getDate();
        }

        $label = $this->words[$label] ?? $label;
        
        $columns = max(3, count($this->data));
        
        $this->SetFont('DejaVuSansCondensed', '', 11);

        $x_pos = ($this->documentWidth) * 0.5 * (1 + ($this->position)/$columns);
        $this->position++;

        $this->setXY($x_pos, 75);

        $this->setTextColor(40, 40, 40);

        $this->cell(($this->documentWidth)*0.5 * 1/3, 5, $label . ':');

        $this->setXY($x_pos, 80);

        $this->setFont('DejaVuSansCondensed', 'B', 11);

        $this->setTextColor(0, 0, 0);

        $this->multiCell(($this->documentWidth)*0.5 * 1/3, 5, $value);
    }

    private function getDate()
    {
        if (strtolower($this->lang) == 'en') {
            return date('d M Y');
        }

        return date('d/m/Y');
    }
}
