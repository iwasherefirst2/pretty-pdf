<?php

namespace BeautyBill;

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/Partials/Header.php';

class BeautyBill
{
    use Traits\PartialLoadable;

    private $pdf;

    public function __construct()
    {
        $this->allowOverwrite = false;

        $this->pdf = new PDF();

        $this->addBasicPartials();
    }

    public function output()
    {
        $this->drawHeaderLine();
        $this->invoiceHeadline();

        return call_user_func_array([$this->pdf, 'output'], func_get_args());
    }
}
