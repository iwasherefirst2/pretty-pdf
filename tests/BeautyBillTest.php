<?php

namespace Tests;

use BeautyBill\BeautyBill;
use PHPUnit\Framework\TestCase;

class BeautyBillTest extends TestCase
{
    public function test_header()
    {
        $bill = new BeautyBill();

        $output = $bill->logo(__DIR__ . '/files/logo2.png')
             ->headerBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->taxNumber('99/999/99999')
             ->output('s');
        //->output('F', 'test.pdf');

        $this->assertEqualPDFs('Header.pdf', $output);
    }

    // One cannot compare the output content directly
    // with the file, because of metadata (creation date).
    // As a workaround, we convert the pdfs to images
    // and compare the images.
    // Credit goes to:
    // https://gordonlesti.com/phpunit-compare-generated-pdf-files-with-imagick/
    private function assertEqualPDFs($filename, $content)
    {
        $pdfContent = file_get_contents(__DIR__ . '/files/' . $filename);

        $assertedImagick = new \Imagick();
        $assertedImagick->readImageBlob($pdfContent);
        $assertedImagick->resetIterator();
        $assertedImagick = $assertedImagick->appendImages(true);

        $testImagick = new \Imagick();
        $testImagick->readImageBlob($content);
        $testImagick->resetIterator();
        $testImagick = $testImagick->appendImages(true);

        $diff = $assertedImagick->compareImages($testImagick, 1);
        $this->assertSame(0.0, $diff[1]);
    }
}
