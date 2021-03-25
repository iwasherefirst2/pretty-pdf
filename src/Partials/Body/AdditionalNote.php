<?php

namespace PrettyPdf\Partials\Body;

use PrettyPdf\Partials\Drawable;

class AdditionalNote extends Drawable
{
    /**
     * @var string
     */
    private $description;

    public function set(string $description)
    {
        $this->description = $description;
    }
    
    public function draw(): void
    {
        $y = $this->pdf->yPositionAfterTotalAmount;
        
        $this->SetFont('DejaVuSansCondensed', 'B', 12);
        
        $this->SetXY(($this->w)*0.5 + $this->sideMargin, $y + 10);
        $this->MultiCell(($this->w)*0.5 - 2* $this->sideMargin, 7, $this->words['Note'], 0, 'L');
        $this->Line(($this->w)*0.5 + $this->sideMargin, $this->GetY()+1, ($this->w)*0.5 + ($this->w)*0.5 - $this->sideMargin, $this->GetY()+1);
        $this->SetFont('DejaVuSansCondensed', '', 10);
        $this->SetXY(($this->w)*0.5+ $this->sideMargin, $this->getY()+ 5);
      
        $this->MultiCell(($this->w)*0.5 - 2*$this->sideMargin, 6, $this->description, 0, 'L');
        $this->SetY($y);
    }
}
