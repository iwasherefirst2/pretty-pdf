<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;

class SetHeaderInfoBox extends Drawable
{
    /**
     * @var int
     */
    private $fontHeight;

    /**
     * @var array
     */
    private $infos;

    public function set(array $infos, int $fontHeight = 8): void
    {
        $this->infos = $infos;
        $this->fontHeight = $fontHeight;
    }
    
    /**
     * Add infobox in the top right corner of invoice
     */
    public function draw(): void
    {
        $this->setFont('DejaVuSansCondensed', '', $this->fontHeight);
        $text = implode("\n", $this->infos);
        $this->setX($this->documentWidth - $this->sideMargin - $this->topInfoBoxWidth);
        $this->multiCell($this->topInfoBoxWidth, 4, $text, '0', 'R');
    }
}
