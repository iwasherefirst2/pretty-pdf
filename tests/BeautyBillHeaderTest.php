<?php

namespace Tests;

use BeautyBill\BeautyBill;

class BeautyBillHeaderTestCase extends BeautyBillTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->bill = new BeautyBill();
    }

    public function test_header_basic()
    {
        $this->bill->logo(__DIR__ . '/files/logo.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States']);
        
        $this->assertEqualPDFs('Header.pdf');
    }

    public function test_date()
    {
        $this->bill->date();

        $this->assertEqualPDFs('Date.pdf');
    }

    public function test_invoice_nr()
    {
        $this->bill->invoiceNumber('I 2020-03-21');

        $this->assertEqualPDFs('InvoiceNumber.pdf');
    }

    public function test_tax_nr()
    {
        $this->bill->taxNumber('18/455/82932');

        $this->assertEqualPDFs('TaxNumber.pdf');
    }

    public function test_full_header()
    {
        $this->bill->logo(__DIR__ . '/files/logo.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->date()
             ->invoiceNumber('I 2020-03-21')
             ->taxNumber('18/455/82932');

        $this->assertEqualPDFs('FullHeader.pdf');
    }

    public function test_dissalow_overwriting_functions_by_default()
    {
        $this->expectException(\Exception::class);
        
        $this->bill->addCustomPartials([\Tests\HeaderLine::class]);
    }
}

class HeaderLine extends \BeautyBill\Partials\Drawable
{
    /**
     * Draw line below logo and header infobox
     */
    public function draw()
    {
        echo 'Hallo';
    }
}
