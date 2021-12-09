<?php

namespace Tests;

use Exception;
use PrettyPdf\Partials\Drawable;
use PrettyPdf\Partials\Invoice\Data\Item;

class PrettyPdfTest extends PrettyPdfTestCase
{
    public function test_complete_document()
    {
        //$this->storeOnly = true;

        $item = new Item();

        $item->description = 'A new currency';
        $item->quantity = 5;
        $item->name = 'Bitcoin';
        $item->unitPrice = 2031.23;

        $item2 = new Item();

        $item2->description = 'Healthy Stuff';
        $item2->quantity = 3;
        $item2->name = 'Tomatos';
        $item2->unitPrice = 0.5;

        $item3 = new Item();

        $item3->description = 'You are welcome to join-';
        $item3->quantity = 12;
        $item3->name = 'Membership';
        $item3->unitPrice = 100;

        $this->prettyPdf->logo(__DIR__ . '/files/logo.png')
            ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
            ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
            ->receiverAddress(['Max Mustermann', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
            ->invoiceBox(['Date' => '26 Mar 2021', 'Invoice' => 'I 2020-03-22', 'Tax-Number' => '18/455/12345'])
            ->items([$item, $item2, $item3], 19)
            ->paymentInfo($this->getPaymentInfo())
            ->additionalNote('Optioanl note. Nothing important here.');

        $this->assertEqualPDFs('CompletePrettyPdf.pdf');
    }

    public function test_dissalow_overwriting_functions_by_default()
    {
        $this->expectException(Exception::class);

        $this->prettyPdf->addCustomPartials([Logo::class]);
    }
}

class Logo extends Drawable
{
    /**
     * Draw line below logo and header infobox
     */
    public function draw(): void
    {
        echo 'Hallo';
    }
}
