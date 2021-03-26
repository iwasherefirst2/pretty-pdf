<?php

namespace Tests;

class PrettyPdfTest extends PrettyPdfTestCase
{
    public function test_complete_document()
    {
        $this->storeOnly = true;

        $data2 = $this->getItemData();

        $data2->unitPrice = 100;
        $data2->quantity = 12;

        $data3 = $this->getItemData();
        $data3->unitPrice = 15;
        $data3->quantity = 5;

        $this->bill->logo(__DIR__ . '/files/logo.png')
            ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
            ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
            ->receiverAddress(['Max Mustermann', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
            ->invoiceBox(['Date' => 'Today', 'Invoice' => 'I 2020-03-22', 'Tax-Number' => '18/455/12345'])
            ->items([$this->getItemData(), $data2, $data3], 19)
            ->paymentInfo($this->getPaymentInfo())
            ->additionalNote('Optioanl note. Nothing important here.');

        $this->assertEqualPDFs('CompletePrettyPdf.pdf');
    }

    public function test_dissalow_overwriting_functions_by_default()
    {
        $this->expectException(\Exception::class);

        $this->bill->addCustomPartials([\Tests\Logo::class]);
    }
}

class Logo extends \PrettyPdf\Partials\Drawable
{
    /**
     * Draw line below logo and header infobox
     */
    public function draw(): void
    {
        echo 'Hallo';
    }
}
