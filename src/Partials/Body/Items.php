<?php

namespace BeautyBill\Partials\Body;

use BeautyBill\Partials\Drawable;

class Items extends Drawable
{
    private $barWidth = 8;

    private $headHight = 45;
    
    /**
     * @var iterable
     */
    private $items;
  
    public function set(iterable $items): void
    {
        $this->items = $items;
    }
    
    public function draw(): void
    {
        $this->drawTableHead();
        
        // draw items
        
        // draw grossamount
    }
    
    private function drawTableHead(): void
    {
        $this->setDrawColor(0, 136, 204);
        $this->setLineWidth($this->barWidth);
        // 106 is the position where one should fold a letter
        // so the address matches the envelope
        $this->line(0, 106 + $this->barWidth/2, $this->documentWidth, 106 + $this->barWidth/2);
        $this->setLineWidth(0);
        $this->setDrawColor(0, 0, 0);
        $this->setTextColor(255, 255, 255);
        $this->setFont('DejaVuSansCondensed', 'B', 10);
        $this->setXY($this->sideMargin, 106);
        $this->cell(($this->documentWidth)*0.5 - $this->sideMargin, $this->barWidth, strtoupper($this->words['Item Description']));
        $this->cell(($this->documentWidth)*0.5*1/3, $this->barWidth, strtoupper($this->words['Unit Price']), 0, 0, 'C');
        $this->cell(($this->documentWidth)*0.5*1/3, $this->barWidth, strtoupper($this->words['Quantity']), 0, 0, 'C');
        $this->cell(($this->documentWidth)*0.5*1/3, $this->barWidth, strtoupper($this->words['Total']), 0, 1, 'C');
    }
    
    private function addItem()
    {
    }
}
