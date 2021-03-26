<?php

namespace Tests;

class InvoiceTest extends PrettyPdfTestCase
{
    public function test_body_basic_net()
    {
        //$this->storeOnly = true;
        
        $this->prettyPdf->items([$this->getItemData()]);
        
        $this->assertEqualPDFs('NetAmount.pdf');
    }

    public function test_body_basic_gross()
    {
        //$this->storeOnly = true;

        $this->prettyPdf->items([$this->getItemData()], 19);

        $this->assertEqualPDFs('GrossAmount.pdf');
    }

    public function test_add_payment_info()
    {
        //$this->storeOnly = true;
        
        $this->prettyPdf->items([$this->getItemData()], 19);
        
        $this->prettyPdf->paymentInfo($this->getPaymentInfo());
        
        $this->prettyPdf->additionalNote('Optioanl note. Nothing important here.');

        $this->assertEqualPDFs('PaymountAmount.pdf');
    }
}
