<?php

namespace BeautyBill\Partials\Header;

use BeautyBill\Partials\PartialInterface;
use Closure;

class Logo implements PartialInterface
{
    /**
     * Add logo to invoice
     * @return Closure
     */
    public static function getFunction(): Closure
    {
        return function (string $path, int $x = 15, int $y = 10, int $w = 0, int $h  = 25) {
            $this->Image($path, $x, $y, $w, $h);
        };
    }
}
