<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Partials\Drawable;

class HeaderInfoBox extends Drawable
{
    /**
     * @var int
     */
    private $fontHeight;

    /**
     * @var int
     */
    private $headHight = 45;

    /**
     * @var int
     */
    private $topInfoBoxWidth = 50;

    /**
     * @var array
     */
    private $infos;

    public function set(array $infos, int $fontHeight = 8): void
    {
        $this->infos      = $infos;
        $this->fontHeight = $fontHeight;
    }
    
    /**
     * Add infobox in the top right corner of invoice
     */
    public function draw(): void
    {
        $this->setFont('DejaVuSansCondensed', '', $this->fontHeight);
        $text = implode("\n", $this->infos);
        $this->setX($this->documentWidth - 10  - $this->topInfoBoxWidth);
        $this->multiCell($this->topInfoBoxWidth, 4, $text, 0,  'R');
        
        $this->addHeaderLine();
    }
    
    private function addHeaderLine()
    {
        $this->setLineWidth(2);
        $this->setDrawColor(224, 224, 224);
        $this->line(0, $this->headHight, ($this->documentWidth) * 0.5, $this->headHight);
        $this->setDrawColor(0, 136, 204);
        $this->line(($this->documentWidth) * 0.5, $this->headHight, $this->documentWidth, $this->headHight);
    }
}
