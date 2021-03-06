<?php

namespace Tests;

use PrettyPdf\PrettyPdf;

class HeaderTestCase extends PrettyPdfTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->prettyPdf = new PrettyPdf();
    }

    public function test_header_basic()
    {
        //$this->storeOnly = true;

        $this->prettyPdf->logo(__DIR__ . '/files/logo.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschra├če 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States']);
        
        $this->assertEqualPDFs('Header.pdf');
    }
    
    public function test_full_header()
    {
        //$this->storeOnly = true;
        
        $this->prettyPdf->logo(__DIR__ . '/files/logo.png')
             ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->returnAddress('Dr. Schwadam, Schwinterfeldschra├če 99, 10777 Berlin, Germany')
             ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->invoiceBox(['Date' => 'Today', 'Invoice' => 'I 2020-03-22', 'Tax-Number' => '18/455/12345']);
        
        $this->assertEqualPDFs('FullHeader.pdf');
    }
}
