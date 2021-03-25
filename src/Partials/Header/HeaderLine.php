<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\Drawable;

class HeaderLine extends Drawable
{
    /**
     * Draw line below logo and header infobox
     */
    public function draw(): void
    {
        $this->setLineWidth(2);
        $this->setDrawColor(224, 224, 224);
        $this->line(0, $this->headHight, ($this->documentWidth) * 0.5, $this->headHight);
        $this->setLineWidth(2);
        $this->setDrawColor(0, 136, 204);
        $this->line(($this->documentWidth) * 0.5, $this->headHight, $this->documentWidth, $this->headHight);
    }
}
