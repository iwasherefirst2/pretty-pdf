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
        //$this->storeOnly = true;
        
        $this->bill->logo(__DIR__ . '/files/logo.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States']);
        
        $this->assertEqualPDFs('Header.pdf');
    }
    
    public function test_full_header()
    {
        //$this->storeOnly = true;
        
        $this->bill->logo(__DIR__ . '/files/logo.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->invoiceBox(['Date' => 'Today', 'Invoice' => 'I 2020-03-22', 'Tax-Number' => '18/455/12345']);
        
        $this->assertEqualPDFs('FullHeader.pdf');
    }
}
