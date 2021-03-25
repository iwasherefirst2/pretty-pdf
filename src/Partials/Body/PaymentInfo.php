<?php

namespace PrettyPdf\Partials\Body;

use PrettyPdf\Partials\Body\Data\PaymentInfo as PaymentInfoData;
use PrettyPdf\Partials\Drawable;

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
        $this->setY($this->pdf->yPositionAfterTable + 25);

        $this->SetFont('DejaVuSansCondensed', 'B', 12);
        
        $this->Cell(($this->w)*0.5 - $this->sideMargin, 7, $this->data->title, 0, 2, 'L');
        $this->Line($this->GetX(), $this->GetY()+1, $this->GetX() + ($this->w)*0.5 - $this->sideMargin, $this->GetY()+1);
        $this->SetFont('DejaVuSansCondensed', '', 10);
        $this->setY($this->getY() +4);
        
        $this->MultiCell(($this->w)*0.5 - $this->sideMargin, 6, $this->data->description, 0, 'L');
        $this->ln();
        $border = 0;

        $this->Cell((($this->w)*0.5 - $this->sideMargin)* 1/4, 6, $this->words['Name:'], $border, 0, 'L');
        $this->Cell((($this->w)*0.5 - $this->sideMargin)* 3/4, 6, $this->data->name, $border, 1, 'L');
        $this->Cell((($this->w)*0.5 - $this->sideMargin)* 1/4, 6, $this->words['Bank:'], $border, 0, 'L');
        $this->Cell((($this->w)*0.5 - $this->sideMargin)* 3/4, 6, $this->data->bank, $border, 1, 'L');
        $this->Cell((($this->w)*0.5 - $this->sideMargin)* 1/4, 6, $this->words['IBAN:'], $border, 0, 'L');
        $this->Cell((($this->w)*0.5 - $this->sideMargin)* 3/4, 6, $this->data->iban, $border, 1, 'L');
        $this->Cell((($this->w)*0.5 - $this->sideMargin)* 1/4, 6, $this->words['BIC/SWIFT:'], $border, 0, 'L');
        $this->Cell((($this->w)*0.5 - $this->sideMargin)* 3/4, 6, $this->data->bic, $border, 1, 'L');
    }
}
