<?php

namespace BeautyBill;

class PDF extends \tFPDF
{
    private $sideMargin = 20;

    private $topMargin = 10;

    private $topInfoBoxWidth = 50;

    private $headHight = 45;

    private $taxNumber;

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
    }

    public function taxNumber($taxNumber)
    {
        $this->taxNumber = $taxNumber;
    }
}
