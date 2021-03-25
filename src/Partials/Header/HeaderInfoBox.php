<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\PartialInterface;
use Closure;

class HeaderInfoBox implements PartialInterface
{
    /**
     * Add infobox in the top right corner of invoice
     * @return Closure
     */
    public static function getFunction(): Closure
    {
        return function (array $infos, int $fontheight = 8) {
            $this->SetFont('DejaVuSansCondensed', '', $fontheight);
            $text = implode("\n", $infos);
            $this->SetX($this->w - $this->sideMargin - $this->topInfoBoxWidth);
            $this->MultiCell($this->topInfoBoxWidth, 4, $text, '0', 'R');
        };
    }
}
