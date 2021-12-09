<?php

namespace PrettyPdf\Partials\Invoice;

use PrettyPdf\Partials\Drawable;

class AdditionalNote extends Drawable
{
    private string $description;
    private float $xStartPosition;
    private float $noteWidht;

    public function set(string $description): void
    {
        $this->description = $description;
    }
    
    public function draw(): void
    {
        $this->xStartPosition = $this->documentWidth * 0.5 + $this->leftMargin;
        $this->noteWidht      = $this->halfContentWidth - $this->rightMargin;

        $this->createTitle();
        $this->createSeperatorLine();
        $this->createDescriptionText();
    }

    private function createTitle(): void
    {
        $yStartPosition = $this->pdf->yPositionAfterTotalAmount + 10;

        $this->SetXY($this->xStartPosition, $yStartPosition);
        $this->setBoldFontSize(12);
        $this->MultiCell($this->noteWidht, 7, $this->words['Note']);
    }

    private function createSeperatorLine(): void
    {
        $this->Line($this->xStartPosition, $this->GetY()+1, $this->documentWidth - $this->rightMargin, $this->GetY()+1);
    }

    private function createDescriptionText(): void
    {
        $this->SetXY($this->xStartPosition, $this->getY()+ 5);
        $this->setPlainFontSize(10);
        $this->MultiCell($this->noteWidht, 6, $this->description);
    }
}
