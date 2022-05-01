<?php

namespace PrettyPdf;

class PDF extends \tFPDF
{
    private int $leftMargin = 20;
    private int $topMargin = 10;
    private int $rightMargin = 10;
    private array $words;
    public int $yPositionAfterTable;
    public int $yPositionAfterTotalAmount;
    public int $halfContentWidth;
    
    const MAP_NAMES = [
        'documentWidth' => 'w',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->SetMargins($this->leftMargin, $this->topMargin);

        $this->AddFont('DejaVuSansCondensed', '', 'DejaVuSansCondensed.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'B', 'DejaVuSansCondensed-Bold.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'BI', 'DejaVuSansCondensed-BoldOblique.ttf', true);
        $this->AddFont('DejaVuSansCondensed', 'I', 'DejaVuSansCondensed-Oblique.ttf', true);

        $this->AliasNbPages();
        $this->SetMargins($this->leftMargin, $this->topMargin);
        $this->AddPage();

        $this->setLocalizationPath(__DIR__ . '/Localization/default.php');

        $this->halfContentWidth = $this->w * 0.5 - $this->leftMargin;
    }
    
    public function setBoldFontSize(float $fontSize): void
    {
        $this->setFont('DejaVuSansCondensed', 'B', $fontSize);
    }
    
    public function addTopMargin(float $margin): void
    {
        $this->setY($this->getY() + $margin);
    }

    public function setPlainFontSize(float $fontSize): void
    {
        $this->setFont('DejaVuSansCondensed', '', $fontSize);
    }

    public function __get($name)
    {
        if (isset(static::MAP_NAMES[$name]) && !empty($name)) {
            $name = static::MAP_NAMES[$name];
        }
        
        return $this->{$name};
    }
    
    public function setLocalizationPath(string $fullPath): void
    {
        if (!file_exists($fullPath)) {
            throw new PrettyPdfException('File ' . $fullPath . ' does not exists.', 1);
        }

        $this->words = include $fullPath;
    }
}
