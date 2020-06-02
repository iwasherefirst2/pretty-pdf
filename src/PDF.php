<?php

namespace BeautyBill;

class PDF extends \tFPDF
{
    public $sideMargin = 20;

    public $topMargin = 10;

    public $topInfoBoxWidth = 50;

    protected $headHight = 45;

    private $methods;

    public function __construct()
    {
        parent::__construct();

        $this->SetMargins($this->sideMargin, $this->topMargin);

        $this->AddFont('DejaVuSansCondensed', '', 'DejaVuSansCondensed.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'B', 'DejaVuSansCondensed-Bold.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'BI', 'DejaVuSansCondensed-BoldOblique.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'I', 'DejaVuSansCondensed-Oblique.ttf', true);

        $this->AliasNbPages();
        $this->SetMargins($this->sideMargin, $this->topMargin);
        $this->AddPage();

        $this->methods = [];
    }

    public function addMethod($method)
    {
        $this->methods[] = $method;
    }
}
