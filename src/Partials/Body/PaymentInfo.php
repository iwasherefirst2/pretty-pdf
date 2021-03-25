<?php

namespace PrettyPdf\Partials\Body;

use PrettyPdf\Partials\Body\Data\PaymentInfo as PaymentInfoData;
use PrettyPdf\Partials\Drawable;
use PrettyPdf\PDF;

class PaymentInfo extends Drawable
{
    /**
     * @var PaymentInfo
     */
    private $data;

    public function set(PaymentInfoData $data)
    {
        $this->data =$data;
    }
    
    public function draw(): void
    {
        $this->setYCoordinateBelowTable();
        
        $this->createTitle();
        
        $this->setPlainFontSize(10);
        
        $this->addDescription();
        
        $this->ln();
        
        $this->addTableRow($this->words['Name:'], $this->data->name);
        $this->addTableRow($this->words['Bank:'], $this->data->bank);
        $this->addTableRow($this->words['IBAN:'], $this->data->iban);
        $this->addTableRow($this->words['BIC/SWIFT:'], $this->data->bic);
    }
    
    private function setYCoordinateBelowTable(): void
    {
        $this->setY($this->pdf->yPositionAfterTable + 25);
    }
    
    private function createTitle(): void
    {
        $this->setBoldFontSize(12);
        
        $cellWidth = $this->documentWidth*0.5 - $this->sideMargin;
        $cellHeight = 7;
        
        $this->cell(
            $cellWidth,
            $cellHeight,
            $this->data->title,
            PDF::NO_BORDER,
            PDF::MOVE_POSITION_BELOW,
            PDF::ALIGN_LEFT
        );

        $yPosition = $this->GetY()+1;
        $this->line(
            $this->GetX(),// Will be new line (Position Below) but with SideMargin
            $yPosition,
            $this->GetX() + ($this->documentWidth)*0.5 - $this->sideMargin,
            $yPosition
        );

        $this->addTopMargin(4);
    }
    
    private function addDescription(): void
    {
        $lineHeight = 6;
        
        $this->MultiCell(
            $this->documentWidth*0.5 - $this->sideMargin,
            $lineHeight,
            $this->data->description,
            PDF::NO_BORDER,
            PDF::ALIGN_LEFT
        );
    }
    
    private function addTableRow(string $label, string $value): void
    {
        $halfDocumentWidht = $this->documentWidth*0.5 - $this->sideMargin;
        $cellHeight = 6;
        
        $this->cell(
            $halfDocumentWidht* 1/4,
            $cellHeight,
            $label,
            PDF::NO_BORDER,
            PDF::MOVE_POSITION_TO_THE_RIGHT,
            PDF::ALIGN_LEFT
        );
        
        $this->cell(
            $halfDocumentWidht * 3/4,
            $cellHeight,
            $value,
            PDF::NO_BORDER,
            PDF::MOVE_POSITION_TO_NEXT_LINE,
            PDF::ALIGN_LEFT
        );
    }
}
