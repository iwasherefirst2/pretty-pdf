<?php

namespace BeautyBill;

class PDF extends \tFPDF
{
    private $sideMargin = 20;

    private $topMargin = 10;

    private $topInfoBoxWidth = 50;

    private $headHight = 45;

    private $data;

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

    /**
     * Store attribute under classname.
     * The name has to be a class, to prevent
     * overwriting of values.
     *
     * @param class $class
     * @param mixed $value
     */
    public function set($class, $value)
    {
        if (!class_exists($class)) {
            throw new \Exception('Class does not exist', 1);
        }

        $this->data[$class] = $value;
    }

    /**
     * Get attribute under classname.
     *
     * @param class $class
     * @param mixed $value
     */
    public function get($class)
    {
        if (!class_exists($class)) {
            throw new \Exception('Class does not exist', 1);
        }

        return $this->data[$class];
    }
}
