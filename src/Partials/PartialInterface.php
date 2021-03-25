<?php

namespace BeautyBill\Partials;

use Closure;

interface PartialInterface
{
    /**
     * Add dynamic function to PDF object.
     * Methodname is equal to interfacename
     * @return Closure
     */
    public static function getFunction(): Closure;
}
