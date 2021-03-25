<?php

namespace Tests;

use BeautyBill\BeautyBill;
use PHPUnit\Framework\TestCase;

class BeautyBillTestCase extends TestCase
{
    protected $storeOnly = false;

    /**
     * var BeautyBill
     */
    protected $bill;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->bill = new BeautyBill();
    }
    
    // One cannot compare the output content directly
    // with the file, because of metadata (creation date will differ).
    // As a workaround, we convert the pdfs to images
    // and compare the images.
    // Credit goes to:
    // https://gordonlesti.com/phpunit-compare-generated-pdf-files-with-imagick/
    protected function assertEqualPDFs($filename)
    {
        if ($this->storeOnly) {
            $this->storePDF($filename, $this->bill);
            return;
        }
        
        $content = $this->bill->output('s');
        
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

    protected function storePDF($filename, BeautyBill $bill)
    {
        $bill->output('F', __DIR__ . '/files/' . $filename);
    }
}
