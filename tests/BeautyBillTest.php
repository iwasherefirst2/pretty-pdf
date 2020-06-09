<?php

namespace Tests;

use BeautyBill\BeautyBill;
use PHPUnit\Framework\TestCase;

class BeautyBillTest extends TestCase
{
    public function test_header_basic()
    {
        $bill = new BeautyBill();

        $output = $bill->logo(__DIR__ . '/files/logo2.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->output('s');

        $this->assertEqualPDFs('Header.pdf', $output);
    }

    public function test_date()
    {
        $bill = new BeautyBill();

        $output = $bill->setDate()
                       ->output('s');

        $this->assertEqualPDFs('Date.pdf', $output);
    }

    public function test_invoice_nr()
    {
        $bill = new BeautyBill();

        $output = $bill->setInvoiceNumber('I 2020-03-21')
                       ->output('s');

        $this->assertEqualPDFs('InvoiceNumber.pdf', $output);
    }

    public function test_tax_nr()
    {
        $bill = new BeautyBill();

        $output = $bill->setTaxNumber('18/455/82932')
                       ->output('s');

        $this->assertEqualPDFs('TaxNumber.pdf', $output);
    }

    public function test_full_header()
    {
        $bill = new BeautyBill();

        $output = $bill->logo(__DIR__ . '/files/logo2.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->setDate()
             ->setInvoiceNumber('I 2020-03-21')
             ->setTaxNumber('18/455/82932')
             ->output('s');

        $this->assertEqualPDFs('FullHeader.pdf', $output);
    }

    public function test_dissalow_overwriting_functions_by_default()
    {
        $this->expectException(\Exception::class);

        $bill = new BeautyBill();

        $bill->addCustomParcials([\Tests\DrawHeaderLine::class]);
    }

    // One cannot compare the output content directly
    // with the file, because of metadata (creation date will differ).
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

class DrawHeaderLine implements \BeautyBill\Parcials\ParcialInterface
{
    /**
     * Draw line below logo and header infobox
     * @return Closure
     */
    public static function getFunction(): \Closure
    {
        return function () {
            echo 'Hallo';
        };
    }
}
