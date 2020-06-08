<?php

namespace BeautyBill;

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/Partials/Header.php';

class BeautyBill
{
    use Traits\ParcialLoadable;

    private $pdf;

    public function __construct()
    {
        $this->allowOverwrite = false;

        $this->pdf = new PDF();

        $this->addBasicParcials();
    }
}
