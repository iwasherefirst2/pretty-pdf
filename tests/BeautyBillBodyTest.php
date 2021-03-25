<?php

namespace Tests;

use BeautyBill\Partials\Body\ItemData;
use BeautyBill\Partials\Body\PaymentInfoData;

class BeautyBillBodyTest extends BeautyBillTestCase
{
    private function getItemData()
    {
        $item = new ItemData();

        $item->description = 'A new currency';
        $item->quantity = 5;
        $item->name = 'Bitcoin';
        $item->unitPrice = 2031.23;
        
        return $item;
    }
    
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
        
        $paymentInfoDate = new PaymentInfoData();
        
        $paymentInfoDate->title = 'A really good title';
        $paymentInfoDate->description = 'A long description comes in here';
        $paymentInfoDate->bank = 'ING';
        $paymentInfoDate->bic = 'BICXXX';
        $paymentInfoDate->iban = 'DE42 4242 4242 4242 4242 24';
        $paymentInfoDate->name = 'Beauty Bill Creator';

        $this->bill->items([$this->getItemData()], 19);
        
        $this->bill->paymentInfo($paymentInfoDate);
        
        $this->bill->additionalNote('Optioanl note. Nothing important here.');

        $this->assertEqualPDFs('PaymountAmount.pdf');
    }
}
