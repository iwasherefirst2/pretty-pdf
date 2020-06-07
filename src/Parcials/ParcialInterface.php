<?php

namespace BeautyBill\Parcials;

interface ParcialInterface
{
    /**
     * Add dynamic function to PDF object.
     * Methodname is equal to interfacename
     * @return Closure
     */
    public static function getFunction(): \Closure;
}
