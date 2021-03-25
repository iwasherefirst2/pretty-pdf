<?php

namespace BeautyBill\Partials;

use BeautyBill\PDF;

/**
 * Class Drawable
 * @package BeautyBill\Partials
 * @property float $headHight
 * @property array $words
 * @property float $documentWidth
 * @property string $lang default is 'en'
 * @property float $sideMargin
 * @property float topInfoBoxWidth
 * @method setLineWidth(int $lineWidth) http://fpdf.org/en/doc/setlinewidth.htm
 * @method setDrawColor(int $red, int $green, int $blue) http://fpdf.org/en/doc/setdrawcolor.htm
 * @method line(float $x1, float $y1, float $x2, float $y2) http://www.fpdf.org/en/doc/line.htm
 * @method setFont(string $font, string $type, int $size)
 * @method setX(float $x)
 * @method setXY(float $x, float $y)
 * @method setTextColor(int $red, int $green, int $blue)
 * @method cell(float $width, float $height=0, string $content='', mixed $border=0, int $nextLine=0, string $align='L', bool $fill = false, mixed $link ='') http://www.fpdf.org/en/doc/cell.htm
 * @method multiCell(float $width, float $height=0, string $content='', mixed $border=0, string $align='L', bool $fill=false) http://www.fpdf.org/en/doc/multicell.htm
 * @method image(string $path, float $xPosition, float $yPosition, float $width, float $height, string $type ='', mixed $link = '') http://www.fpdf.org/en/doc/image.htm
 */
abstract class Drawable
{
    /**
     * @var PDF
     */
    protected $pdf;
    
    public function __call($name, $arguments)
    {
        call_user_func_array([$this->pdf, $name], $arguments);
    }
    
    public function __get($name)
    {
        return $this->pdf->{$name};
    }
      
    public function setPdf(PDF $pdf)
    {
        $this->pdf = $pdf;
    }
}
