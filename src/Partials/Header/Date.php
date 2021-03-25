<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;

class Date extends Drawable
{
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
        $this->setFont('DejaVuSansCondensed', '', 11);

        $this->setXY(($this->documentWidth) * 0.5, 75);

        $this->setTextColor(40, 40, 40);

        $this->cell(($this->documentWidth) * 0.5 * 1 / 3, 5, $this->words['Date'] . ':');

        $this->setXY(($this->documentWidth) * 0.5, 80);

        $this->setFont('DejaVuSansCondensed', 'B', 11);

        $this->setTextColor(0, 0, 0);

        $this->multiCell(($this->documentWidth) * 0.5 * 1 / 3, 5, $this->getDate());
    }
    
    private function getDate()
    {
        if (strtolower($this->lang) == 'en') {
            return date('d M Y', $this->timestamp);
        }
        
        return date('d/m/Y', $this->timestamp);
    }
}
