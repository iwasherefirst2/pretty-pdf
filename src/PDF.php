<?php

namespace BeautyBill;

class PDF extends \tFPDF
{
    private $sideMargin = 20;

    private $topMargin = 10;

    private $topInfoBoxWidth = 50;

    private $headHight = 45;

    private $data;

    private $words;

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

        $this->localize('en');
    }

    public function localize($lang)
    {
        if (!file_exists(__DIR__ . '/Localization/' . $lang . '.php')) {
            throw new \Exception('File ' . $lang . '.php does not exists.', 1);
        }

        $this->words = include __DIR__ . '/Localization/' . $lang . '.php';

        var_dump($this->words);
    }
}
