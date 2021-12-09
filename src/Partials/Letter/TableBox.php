<?php

namespace PrettyPdf\Partials\Letter;

use PrettyPdf\Builder\Cell;
use PrettyPdf\Partials\Drawable;

class TableBox extends Drawable
{
    private string $title;
    private array $rows;
    private array $header;

    public function set(string $title, array $rows): void
    {
        $this->title = $title;
        $this->rows  = $rows;
    }

    public function draw(): void
    {
        $this->addHeadline();
        $this->createTable();
    }

    private function addHeadline(): void
    {
        $this->setPlainFontSize(38);
        $this->SetXY($this->documentWidth * 0.5 + 5, 55);
        $this->Cell($this->documentWidth*0.5, 10, strtoupper($this->title), Cell::NO_BORDER, Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_PREVIOUS_CELL);
        $this->ln(8);
    }

    private function refreshX(): void
    {
        $this->SetX($this->documentWidth * 0.5 * (1.1));
    }

    private function createTable(): void
    {
        $height = 8;
        $borderHead = 'RB';
        $borderNorm = 'R';
        $align = 'C';

        $this->SetLineWidth(0);
        $this->SetDrawColor(0, 0, 0);

        $this->cellBuilder->newPosition = Cell::MOVE_POSITION_TO_THE_RIGHT;
        $this->cellBuilder->align = Cell::ALIGN_CENTER;
        $this->cellBuilder->height = 8;
        $this->cellBuilder->border = 'RB';
        $this->cellBuilder->width = $this->documentWidth * 0.1;

        $this->refreshX();
        $this->setPlainFontSize(11);
        $this->SetTextColor(40, 40, 40);

        $numItems = count([1, 2, 3, 4]);
        $i = 0;
        foreach ([1, 2, 3, 4] as $key=>$value) {
            if (++$i === $numItems) {
                $this->cellBuilder->border = 'B';
                $this->cellBuilder->newPosition = Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_PREVIOUS_CELL;
            }
            $this->cellBuilder->create($value);
        }

        $this->setBoldFontSize(11);
        $this->SetTextColor(0, 0, 0);

        foreach ($this->rows as $row) {
            $this->refreshX();
            $numItems = count($row);
            $i = 0;
            $this->cellBuilder->border = 'R';
            $this->cellBuilder->newPosition = Cell::MOVE_POSITION_TO_THE_RIGHT;
            foreach ($row as $column) {
                if (++$i === $numItems) {
                    $this->cellBuilder->border = CELL::NO_BORDER;
                    $this->cellBuilder->newPosition = Cell::MOVE_POSITION_TO_NEXT_LINE_START_AT_PREVIOUS_CELL;
                }
                $this->cellBuilder->create((string) $column);
            }
        }
    }
}
