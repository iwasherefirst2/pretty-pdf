<?php

namespace Tests;

use BeautyBill\BeautyBill;

class BeautyBillBodyTest extends BeautyBillTestCase
{
    public function test_body_basic()
    {
        $bill = new BeautyBill();

        $output = $bill->setLogo(__DIR__ . '/files/logo.png')
             ->setHeaderInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
             ->setReturnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
             ->setReceiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
             ->output('s');

        $this->assertEqualPDFs('Header.pdf', $output);
    }
}
