<?php

namespace BeautyBill\Parcials\Header;

use BeautyBill\Parcials\ParcialInterface;

class Logo implements ParcialInterface
{
    public static function getFunction(): \Closure
    {
        return function (string $path, int $x = 15, int $y = 10, int $w = 0, int $h  =25) {
            $this->Image($path, $x, $y, $w, $h);
        };
    }
}
