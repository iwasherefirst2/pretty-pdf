<?php

namespace BeautyBill;

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/Partials/Header.php';

class BeautyBill
{
    use Traits\ParcialLoadable;

    private $pdf;

    private $timestamp;

    public function __construct(array $parcials = [])
    {
        $this->timestamp = time();

        $this->pdf = new PDF();

        $this->addBasicParcials();

        $this->load($parcials);

        $this->drawHeaderLine();
    }
}
