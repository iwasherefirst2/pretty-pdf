<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Builder\Cell;
use PrettyPdf\Partials\Drawable;

class HeaderInfoBox extends Drawable
{
    private int $fontHeight;
    private int $headHight = 45;
    private int $topInfoBoxWidth = 50;
    private array $infos;

    public function set(array $infos, int $fontHeight = 8): void
    {
        $this->infos      = $infos;
        $this->fontHeight = $fontHeight;
    }

    // Add infobox in the top right corner of invoice
    public function draw(): void
    {
        $this->setPlainFontSize($this->fontHeight);

        $text = implode("\n", $this->infos);

        $this->setX($this->documentWidth - $this->rightMargin  - $this->topInfoBoxWidth);

        $this->multiCell(
            $width = $this->topInfoBoxWidth,
            $height = 4,
            $text,
            Cell::NO_BORDER,
            Cell::ALIGN_RIGHT
        );
        
        $this->addHeaderLine();
    }
    
    private function addHeaderLine(): void
    {
        $this->setLineWidth(2);

        $this->setDrawColor(224, 224, 224);
        $this->drawLine(
            0,
            $this->documentWidth * 0.5
        );

        $this->setDrawColor(0, 136, 204);
        $this->drawLine(
            $this->documentWidth * 0.5,
            $this->documentWidth
        );
    }

    private function drawLine(float $from, float $to): void
    {
        $this->line($from, $this->headHight, $to, $this->headHight);
    }
}
