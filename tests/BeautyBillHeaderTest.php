<?php

namespace Tests;

use BeautyBill\BeautyBill;

class BeautyBillHeaderTestCase extends BeautyBillTestCase
{
    public function test_header_basic()
    {
        $bill = new BeautyBill();

        $output = $bill->setLogo(__DIR__ . '/files/logo.png')
             ->setHeaderInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->setReturnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->setReceiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->output('s');

        $this->assertEqualPDFs('Header.pdf', $output);
    }

    public function test_date()
    {
        $bill = new BeautyBill();
        
        $output = $bill->setDate()->output('s') ;

        //$this->storePDF($bill, 'OM2G.pdf');

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

        $output = $bill->setLogo(__DIR__ . '/files/logo.png')
             ->setHeaderInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->setReturnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->setReceiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
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

        $bill->addCustomPartials([\Tests\DrawHeaderLine::class]);
    }
}

class DrawHeaderLine extends \BeautyBill\Partials\Drawable
{
    /**
     * Draw line below logo and header infobox
     */
    public function draw()
    {
        echo 'Hallo';
    }
}
