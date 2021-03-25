<?php

namespace PrettyPdf\Partials\Body;

use PrettyPdf\Partials\Drawable;

class Items extends Drawable
{
    private $barWidth = 8;
    
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
        $this->drawTableHead();
        
        foreach ($this->items as $item) {
            $this->addItem($item);
        }
        
        $this->completeTable();
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
    
    private function addItem($item)
    {
        $this->sum = $this->sum + $item->quantity * $item->getPrice();
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(224, 224, 224);
        $this->SetDrawColor(224, 224, 224);
        $this->SetX(0);
        $yOld = $this->getY();
        $this->Cell($this->w * 0.5, 3, '', 1, 2, '', 1);
        $this->Cell($this->sideMargin, 5, '', 1, 0);
        $this->SetFont('DejaVuSansCondensed', 'B', 9);
        $this->Cell(($this->w)*0.5 - $this->sideMargin, 5, $item->name, 1, 2);
        $this->SetFont('DejaVuSansCondensed', '', 8);
        $this->MultiCell(($this->w)*0.5 - $this->sideMargin, 4, $item->description, 0, 'L');
        $this->Cell($this->w * 0.5 - $this->sideMargin, 3, '', 1, 2, '', 1);

        $x = $this->GetX();
        $y = $this->GetY();
        $this->Rect(0, $yOld, $this->w * 0.5, $y - $yOld, 'F');

        $this->SetY($yOld);
        $this->SetX(0);

        $this->Cell($this->w * 0.5, 3, '', 1, 2);
        $this->Cell($this->sideMargin, 5, '', 1, 0);
        $this->SetFont('DejaVuSansCondensed', 'B', 9);
        $this->Cell(($this->w)*0.5 - $this->sideMargin, 5, $item->name, 1, 2);
        $this->SetFont('DejaVuSansCondensed', '', 8);
        $this->MultiCell(($this->w)*0.5 -  $this->sideMargin, 4, $item->description, 0, 'L');
        $this->Cell($this->w * 0.5 - $this->sideMargin, 3, '', 0, 0);

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
        $this->Rect($x, $y, $this->documentWidth * 0.5*(1/3)* 2 + ($this->documentWidth * 0.5* 1/9), 8, 'F');
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
        
        $this->SetFont('DejaVuSansCondensed', 'B', 11);
        $this->Cell($this->documentWidth*0.5*1/3, 8, $this->words['Gross amount'], 0, 2, 'R');
        $this->SetFont('DejaVuSansCondensed', '', 11);
        $this->Cell($this->documentWidth*0.5*1/3, 8, $this->words['Net amount'], 0, 2, 'R');
        $vat = str_replace('?', $this->grossPercentage . ' %', $this->words['Incl. ? VAT.']);
        $this->Cell($this->documentWidth*0.5*1/3, 8, $vat, 0, 0, 'R');
        $this->SetXY($this->GetX(), $yPos);
        $this->SetFont('DejaVuSansCondensed', 'B', 11);
        $this->Cell($this->documentWidth*0.5*1/3, 8, $betrag, 0, 2, 'R');
        $this->SetFont('DejaVuSansCondensed', '', 11);
        $this->Cell($this->documentWidth*0.5*1/3, 8, $netto, 0, 2, 'R');
        $this->Cell($this->documentWidth*0.5*1/3, 8, $mehrWert, 0, 1, 'R');

        return $this->words['Gross amount'];
    }
}
