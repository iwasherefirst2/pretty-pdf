<?php

namespace PrettyPdf\Partials\Invoice;

use PrettyPdf\Builder\Cell;
use PrettyPdf\Partials\Invoice\Data\PaymentInfo as PaymentInfoData;
use PrettyPdf\Partials\Drawable;

class PaymentInfo extends Drawable
{
    private PaymentInfoData $data;

    public function set(PaymentInfoData $data): void
    {
        $this->data =$data;
    }
    
    public function draw(): void
    {
        $this->cellBuilder->width       = $this->halfContentWidth - 5;
        $this->cellBuilder->newPosition = Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_SIDEMARGIN;

        $this->setYCoordinateBelowTable();
        $this->createTitle();
        $this->createSeperatorLine();
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
        $this->cellBuilder->height = 7;
        $this->cellBuilder->create($this->data->title);
    }

    private function createSeperatorLine(): void
    {
        $yPosition = $this->GetY()+1;
        $this->line(
            $this->GetX(),// Will be new line (Position Below) but with SideMargin (because getY() resets X)
            $yPosition,
            $this->GetX() + $this->cellBuilder->width,
            $yPosition
        );

        $this->addTopMargin(4);
    }
    
    private function addDescription(): void
    {
        $this->cellBuilder->height = 6;
        $this->setPlainFontSize(10);

        $this->cellBuilder->createMulticell($this->data->description);
    }
    
    private function addTableRow(string $label, string $value): void
    {
        $this->cellBuilder->create(
            $label,
            $this->cellBuilder->width * 1/4,
            Cell::MOVE_POSITION_TO_THE_RIGHT
        );

        $this->cellBuilder->create(
            $value,
            $this->cellBuilder->width * 3/4,
            Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_SIDEMARGIN
        );
    }
}
