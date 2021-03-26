<?php

namespace PrettyPdf\Partials\Body\Items;

use PrettyPdf\Builder\Cell;
use PrettyPdf\Partials\PDFSynchronized;
use PrettyPdf\PDF;

class TableHeader
{
    use PDFSynchronized;

    private $barWidth = 8;

    /**
     * @var Cell
     */
    private $cellBuilder;

    /**
     * DrawTable constructor.
     * @param PDF $pdf
     * @param Cell $cellBuilder
     */
    public function __construct(PDF $pdf, Cell $cellBuilder)
    {
        $this->pdf = $pdf;
        $this->cellBuilder = $cellBuilder;
    }

    public function draw(): void
    {
        $this->createBar();

        $this->setupFont();

        $this->setXY($this->leftMargin, 106);

        $this->cellBuilder->create(
            strtoupper($this->words['Item Description']),
            $this->documentWidth*0.5 - $this->leftMargin
        );

        $this->cellBuilder->width = $this->documentWidth*0.5*1/3;
        $this->cellBuilder->align = Cell::ALIGN_CENTER;

        $this->cellBuilder->create(
            strtoupper($this->words['Unit Price'])
        );

        $this->cellBuilder->create(
            strtoupper($this->words['Quantity'])
        );

        $this->cellBuilder->create(
            strtoupper($this->words['Total']),
            null,
            Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_BOX
        );

        $this->cellBuilder->resetToDefault();
    }

    private function createBar()
    {
        $this->setDrawColor(0, 136, 204);
        $this->setLineWidth($this->barWidth);

        // 106 is the position where one should fold a letter
        // so the address matches the envelope
        $this->line(0, 106 + $this->barWidth/2, $this->documentWidth, 106 + $this->barWidth/2);
    }

    private function setupFont()
    {
        $this->setLineWidth(0);
        $this->setDrawColor(0, 0, 0);
        $this->setTextColor(255, 255, 255);
        $this->setBoldFontSize(10);
        $this->cellBuilder->height = $this->barWidth;
    }
}
