<?php

namespace BeautyBill\Parcials;

abstract class ParcialAbstract
{
    public static $functionname;

    abstract public static function getFunction(): \Closure;
}
