<?php

namespace Tests;

use BeautyBill\BeautyBill;

class BeautyBillHeaderTestCase extends BeautyBillTestCase
{
    public function test_header_basic()
    {
        $bill = new BeautyBill();

        $output = $bill->logo(__DIR__ . '/files/logo.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->output('s');

        $this->assertEqualPDFs('Header.pdf', $output);
    }

    public function test_date()
    {
        $bill = new BeautyBill();
        
        $output = $bill->date()->output('s') ;

        //$this->storePDF($bill, 'OM2G.pdf');

        $this->assertEqualPDFs('Date.pdf', $output);
    }

    public function test_invoice_nr()
    {
        $bill = new BeautyBill();

        $output = $bill->invoiceNumber('I 2020-03-21')
                       ->output('s');

        $this->assertEqualPDFs('InvoiceNumber.pdf', $output);
    }

    public function test_tax_nr()
    {
        $bill = new BeautyBill();

        $output = $bill->taxNumber('18/455/82932')
                       ->output('s');

        $this->assertEqualPDFs('TaxNumber.pdf', $output);
    }

    public function test_full_header()
    {
        $bill = new BeautyBill();

        $output = $bill->logo(__DIR__ . '/files/logo.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->date()
             ->invoiceNumber('I 2020-03-21')
             ->taxNumber('18/455/82932')
             ->output('s');

        $this->assertEqualPDFs('FullHeader.pdf', $output);
    }

    public function test_dissalow_overwriting_functions_by_default()
    {
        $this->expectException(\Exception::class);

        $bill = new BeautyBill();

        $bill->addCustomPartials([\Tests\HeaderLine::class]);
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
