<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Builder\Cell;
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
        $this->setPlainFontSize(38);
        $this->setXY($this->documentWidth*0.5 + 5, 55);
        $this->cell(
            $width = 100,
            $height = 10,
            strtoupper($this->headline ?? $this->words['Invoice']),
            Cell::NO_BORDER,
            Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_BOX
        );
    }

    private function addInvoiceBoxEntry(string $label, string $value)
    {
        if ($label == 'Date' && $value == 'Today') {
            $value = $this->getDate();
        }

        $label = $this->words[$label] ?? $label;
        
        $columns = max(3, count($this->data));

        $this->setPlainFontSize(11);

        $startPos = $this->documentWidth * 0.5 +5 ;
        $x_pos = $startPos + $this->position/$columns * ($this->documentWidth* 0.5-15);
        $this->position++;

        $this->setXY($x_pos, 75);

        $this->setTextColor(40, 40, 40);

        $this->cell(($this->documentWidth*0.5-15) * 1/3, 5, $label . ':');

        $this->setXY($x_pos, 80);

        $this->setBoldFontSize(11);

        $this->setTextColor(0, 0, 0);

        $this->multiCell(($this->documentWidth*0.5-15) * 1/3, 5, $value);
    }

    private function getDate()
    {
        if (strtolower($this->lang) == 'en') {
            return date('d M Y');
        }

        return date('d/m/Y');
    }
}
