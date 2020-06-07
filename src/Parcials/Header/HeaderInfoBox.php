<?php

namespace BeautyBill\Parcials\Header;

use BeautyBill\Parcials\ParcialInterface;

class HeaderInfoBox implements ParcialInterface
{
    public static function getFunction(): \Closure
    {
        return function (array $infos, int $fontheight = 8) {
            $this->SetFont('DejaVuSansCondensed', '', 8);
            $text = implode("\n", $infos);
            $this->SetX($this->w - $this->sideMargin - $this->topInfoBoxWidth);
            $this->MultiCell($this->topInfoBoxWidth, 4, $text, '0', 'R');
        };
    }
}
