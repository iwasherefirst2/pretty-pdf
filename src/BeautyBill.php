<?php

namespace BeautyBill;

require_once __DIR__ . '/../vendor/autoload.php';

class BeautyBill extends \tFPDF
{
    protected $infoText;

    protected $timestamp;

    protected $sideMargin = 20;

    protected $topMargin = 10;

    protected $headHight = 45;

    protected $barWidth = 8;

    protected $topInfoBoxWidth = 50;

    public function __construct()
    {
        parent::__construct();

        $this->timestamp = time();

        $this->SetMargins($this->sideMargin, $this->topMargin);

        $this->AddFont('DejaVuSansCondensed', '', 'DejaVuSansCondensed.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'B', 'DejaVuSansCondensed-Bold.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'BI', 'DejaVuSansCondensed-BoldOblique.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'I', 'DejaVuSansCondensed-Oblique.ttf', true);

        $this->AliasNbPages();
        $this->SetMargins($this->sideMargin, $this->topMargin);
        $this->AddPage();

        $this->drawHeaderLine();
    }

    public function logo(string $path, int $x = 15, int $y = 10, int $w = 0, int $h  =25)
    {
        $this->Image($path, $x, $y, $w, $h);

        return $this;
    }

    public function headerBox(array $infos, int $fontheight = 8)
    {
        $this->SetFont('DejaVuSansCondensed', '', 8);
        $text = implode("\n", $infos);
        $this->SetX($this->w - $this->sideMargin - $this->topInfoBoxWidth);
        $this->MultiCell($this->topInfoBoxWidth, 4, $text, '0', 'R');

        return $this;
    }

    private function drawHeaderLine()
    {
        $this->SetLineWidth(2);
        $this->SetDrawColor(224, 224, 224);
        $this->Line(0, $this->headHight, ($this->w) * 0.5, $this->headHight);
        $this->SetLineWidth(2);
        $this->SetDrawColor(0, 136, 204);
        $this->Line(($this->w) * 0.5, $this->headHight, $this->w, $this->headHight);
    }
}
