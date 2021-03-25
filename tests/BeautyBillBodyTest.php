<?php

namespace Tests;

class BeautyBillBodyTest extends BeautyBillTestCase
{
    public function test_body_basic()
    {
        $this->bill->items([]);
        
        $this->storeOnly = true;
        
        $this->assertEqualPDFs('Test.pdf');
    }
}
