<?php

namespace Tests;

class BeautyBillBodyTest extends BeautyBillTestCase
{
    public function test_body_basic_net()
    {
        //$this->storeOnly = true;
        
        $this->bill->items([$this->getItemData()]);
        
        $this->assertEqualPDFs('NetAmount.pdf');
    }

    public function test_body_basic_gross()
    {
        //$this->storeOnly = true;

        $this->bill->items([$this->getItemData()], 19);

        $this->assertEqualPDFs('GrossAmount.pdf');
    }

    public function test_add_payment_info()
    {
        //$this->storeOnly = true;
        
        $this->bill->items([$this->getItemData()], 19);
        
        $this->bill->paymentInfo($this->getPaymentInfo());
        
        $this->bill->additionalNote('Optioanl note. Nothing important here.');

        $this->assertEqualPDFs('PaymountAmount.pdf');
    }
}
