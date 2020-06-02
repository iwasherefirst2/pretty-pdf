<?php

namespace BeautyBill\Parcials;

class Logo extends ParcialAbstract
{
    public static $functionname = 'logo';

    public static function getFunction(): \Closure
    {
        return function (string $path, int $x = 15, int $y = 10, int $w = 0, int $h  =25) {
            $this->Image($path, $x, $y, $w, $h);
        };
    }
}
