<?php

namespace PrettyPdf\Partials\Body\Items;

use PrettyPdf\Builder\Cell;
use PrettyPdf\Partials\Drawable;

class Items extends Drawable
{
    /**
     * @var iterable
     */
    private $items;
    
    private $currency;
    
    private $grossPercentage;

    /**
     * @var float
     */
    private $sum = 0;

    public function set(iterable $items, $grossPercentage = 0, $currency = '€'): void
    {
        $this->items           = $items;
        $this->currency        = $currency;
        $this->grossPercentage = $grossPercentage;
    }
    
    public function draw(): void
    {
        $drawTable = new TableHeader($this->pdf, $this->cellBuilder);

        $drawTable->draw();
        
        foreach ($this->items as $item) {
            $this->addItem($item);
        }

        $this->completeTable();
    }
    
    private function addItem($item)
    {
        $this->sum = $this->sum + $item->quantity * $item->getPrice();

        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(224, 224, 224);
        $this->SetDrawColor(224, 224, 224);
        $this->SetX(0);
        $yOld = $this->getY();

        $this->Cell($this->documentWidth * 0.5, 3, '', 1, 2, '', 1);
        $this->Cell($this->leftMargin, 5, '', 1, 0);

        $this->setBoldFontSize(9);

        $this->Cell($this->documentWidth*0.5 - $this->leftMargin, 5, $item->name, 1, 2);
        $this->setPlainFontSize(8);
        $this->MultiCell($this->documentWidth*0.5 - $this->leftMargin, 4, $item->description, 0, 'L');
        $this->Cell($this->documentWidth * 0.5 - $this->leftMargin, 3, '', 1, 2, '', 1);

        $y = $this->GetY();
        $this->Rect(0, $yOld, $this->documentWidth * 0.5, $y - $yOld, 'F');

        $this->SetY($yOld);
        $this->SetX(0);

        $this->Cell($this->documentWidth * 0.5, 3, '', 1, 2);
        $this->Cell($this->leftMargin, 5, '', 1, 0);
        $this->SetFont('DejaVuSansCondensed', 'B', 9);
        $this->Cell(($this->w)*0.5 - $this->leftMargin, 5, $item->name, 1, 2);
        $this->SetFont('DejaVuSansCondensed', '', 8);
        $this->MultiCell(($this->w)*0.5 -  $this->leftMargin, 4, $item->description, 0, 'L');
        $this->Cell($this->w * 0.5 - $this->leftMargin, 3, '', 0, 0);

        $this->SetY($yOld);
        $this->SetX($this->w * 0.5);
        $this->SetFont('DejaVuSansCondensed', '', 9);
        $this->Cell($this->w * 0.5* 1/3, $y-$yOld, $this->round($item->getPrice()), 0, 0, 'C');
        $this->Cell($this->w * 0.5* 1/3, $y-$yOld, $item->quantity, 0, 0, 'C');
        $this->Cell($this->w * 0.5* 1/3 * 2/3, $y-$yOld, $this->round($item->quantity * $item->getPrice()), 0, 1, 'R');
        $this->SetFillColor(150, 150, 150);
        $this->SetX(0);
        $this->Cell($this->w, 0.3, '', 1, 1, '', 1);
    }

    private function round($number): string
    {
        return number_format((float) $number, 2, ',', '.') . ' ' . $this->currency;
    }
    
    private function completeTable(): void
    {
        $betrag    = $this->round($this->sum);

        $this->pdf->yPositionAfterTable = $this->GetY();
        
        $y = $this->GetY()+5;
       
        $x = $this->documentWidth * (0.5 + 1/3 * 0.5) - ($this->documentWidth * 0.5* 1/9);
        $this->SetXY($x, $y);

        $labelTotal = $this->addGross();
        
        $y = $this->GetY() + 5;
        $this->SetFont('DejaVuSansCondensed', 'B', 12);
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(0, 136, 204);
        $this->SetXY($x, $y);
        $this->Rect($this->documentWidth *0.5 + $this->leftMargin, $y, $this->documentWidth * 0.5 - $this->leftMargin, 8, 'F');
        $this->Cell($this->documentWidth*0.5*1/3, 8, $labelTotal, 0, 0, 'R');
        $this->Cell($this->documentWidth*0.5*1/3, 8, $betrag, 0, 1, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(50, 50, 50);

        $this->pdf->yPositionAfterTotalAmount = $this->GetY();
    }
    
    private function addGross()
    {
        if (empty($this->grossPercentage)) {
            return $this->words['Net amount'];
        }

        $netto     = $this->sum *(1 - $this->grossPercentage/100);
        $mehrWert  = $this->sum - $netto;

        $netto     = $this->round($netto);
        $betrag    = $this->round($this->sum);
        $mehrWert  = $this->round($mehrWert);
    
        $yPos = $this->GetY();

        $this->cellBuilder->width = $this->documentWidth*0.5*1/3;
        $this->cellBuilder->align = Cell::ALIGN_RIGHT;
        $this->cellBuilder->height = 8;
        $this->cellBuilder->newPosition = Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_SIDEMARGIN;

        $this->setBoldFontSize(11);
        $this->cellBuilder->create($this->words['Gross amount']);

        $this->setPlainFontSize(11);
        $this->cellBuilder->create($this->words['Net amount']);
        $this->cellBuilder->create($this->getVat(), null, Cell::MOVE_POSITION_TO_THE_RIGHT);

        $this->SetXY($this->GetX(), $yPos);
        $this->setBoldFontSize(11);
        $this->cellBuilder->create($betrag);

        $this->setPlainFontSize(11);
        $this->cellBuilder->create($netto);
        $this->cellBuilder->create($mehrWert);

        return $this->words['Gross amount'];
    }

    private function getVat(): string
    {
        return  str_replace('?', $this->grossPercentage . ' %', $this->words['Incl. ? VAT.']);
    }
}
