<?php

namespace BeautyBill\Parcials\Finisher;

use BeautyBill\Parcials\ParcialInterface;

class DrawHeaderLine implements ParcialInterface
{
    /**
     * Draw line below logo and header infobox
     * @return Closure
     */
    public static function getFunction(): \Closure
    {
        return function () {
            $this->SetLineWidth(2);
            $this->SetDrawColor(224, 224, 224);
            $this->Line(0, $this->headHight, ($this->w) * 0.5, $this->headHight);
            $this->SetLineWidth(2);
            $this->SetDrawColor(0, 136, 204);
            $this->Line(($this->w) * 0.5, $this->headHight, $this->w, $this->headHight);
        };
    }
}
