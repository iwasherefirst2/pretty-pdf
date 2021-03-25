<?php

namespace PrettyPdf;

class PDF extends \tFPDF
{
    const NO_BORDER = 0;

    const BORDER    = 1;

    const ALIGN_LEFT = 'L';

    const MOVE_POSITION_BELOW = 2;
    
    const MOVE_POSITION_TO_NEXT_LINE = 1;

    const MOVE_POSITION_TO_THE_RIGHT = 0;
    
    private $sideMargin = 20;

    private $topMargin = 10;
    
    private $words;

    private $lang;
    
    public $yPositionAfterTable;
    
    public $yPositionAfterTotalAmount;
    
    private $mapNames = [
        'documentWidth' => 'w',
    ];
    
    private $localizationPath;

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

        $this->setLocalizationPath(__DIR__ . '/Localization/');
        $this->localize('en');
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
        if (isset($this->mapNames[$name]) && !empty($name)) {
            $name = $this->mapNames[$name];
        }
        
        return $this->{$name};
    }
    
    public function setLocalizationPath(string $localizationPath): void
    {
        $this->localizationPath = $localizationPath;
    }

    public function localize($lang)
    {
        $fullPath = $this->localizationPath . $lang . '.php';
        
        if (!file_exists($fullPath)) {
            throw new \Exception('File ' . $fullPath . ' does not exists.', 1);
        }

        $this->words = include $fullPath;

        $this->lang = $lang;
    }
}
