<?php

namespace PrettyPdf\Partials;

use PrettyPdf\Builder\Cell;
use PrettyPdf\PDF;

/**
 * Class Drawable
 * @package PrettyPdf\Partials
 * @property float $headHight
 * @property array $words
 * @property float $documentWidth
 * @property string $lang default is 'en'
 * @property float $leftMargin // Is actually only the left margin
 * @property float $rightMargin
 * @property float $topInfoBoxWidth
 * @property float $halfContentWidth // Half documentwidth minus sideMargin.
 * @method setLineWidth(int $lineWidth) http://fpdf.org/en/doc/setlinewidth.htm
 * @method setDrawColor(int $red, int $green, int $blue) http://fpdf.org/en/doc/setdrawcolor.htm
 * @method line(float $x1, float $y1, float $x2, float $y2) http://www.fpdf.org/en/doc/line.htm
 * @method setFont(string $font, string $type, int $size)
 * @method setX(float $x)
 * @method setXY(float $x, float $y)
 * @method setTextColor(int $red, int $green, int $blue)
 * @method cell(float $width, float $height=0, string $content='', mixed $border=null, int $nextLine=0, string $align='L', bool $fill = false, mixed $link ='') http://www.fpdf.org/en/doc/cell.htm
 * @method multiCell(float $width, float $height=0, string $content='', mixed $border=0, string $align='L', bool $fill=false) http://www.fpdf.org/en/doc/multicell.htm
 * @method image(string $path, float $xPosition, float $yPosition, float $width, float $height, string $type ='', mixed $link = '') http://www.fpdf.org/en/doc/image.htm
 * @method setBoldFontSize(float $size)
 * @method setPlainFontSize(float $size)
 */
abstract class Drawable
{
    use PDFSynchronized;

    protected Cell $cellBuilder;

    public function __construct(Cell $cellBuilder)
    {
        $this->cellBuilder = $cellBuilder;
    }
    
    abstract public function draw(): void;
      
    public function setPdf(PDF $pdf): void
    {
        $this->pdf = $pdf;
    }
}
