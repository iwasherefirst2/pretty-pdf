<?php

namespace Tests;

class LetterTest extends PrettyPdfTestCase
{
    public function test_fold_mark_letter()
    {
        // $this->storeOnly = true;
        
        $this->prettyPdf->foldMarker();
        
        $this->assertEqualPDFs('FoldMarker.pdf');
    }

    public function test_date_letter()
    {
        //$this->storeOnly = true;

        $this->prettyPdf->date();

        $this->assertEqualPDFs('Date.pdf');
    }

    public function test_full_letter()
    {
        //$this->storeOnly = true;

        $data = [['a', 'b', 'c', 'd'], ['a', 'b', 'c', 5], [4, 5, 6, 3], [10, 7, 8, 9]];

        $this->prettyPdf->logo(__DIR__ . '/files/logo.png')
            ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
            ->returnAddress('Dr. Schwadam, Schwinterfeldschra├če 99, 10777 Berlin, Germany')
            ->receiverAddress(['Max Mustermann', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
            ->date()
            ->foldMarker()
            ->text("Dear Anit,\nthis is atest.\n\nEnjoy.")
            ->tableBox('Hi', $data);

        $this->assertEqualPDFs('Letter.pdf');
    }
}
