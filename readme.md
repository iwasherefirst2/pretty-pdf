# PrettyPdf

This package helps you to create invoices and letters. Its especialy made for A4 format that fits your envelope window. UTF8 is also supported.

The invoice looks like this:
![image](https://user-images.githubusercontent.com/1765602/112662390-ed54f900-8e57-11eb-905f-957982939b81.png)

Each section of the invoice relates to a method:
![image](https://user-images.githubusercontent.com/1765602/112663289-f0041e00-8e58-11eb-81cd-2826b0780f4b.png)



## Example

```php 

    $item = new \PrettyPdf\Partials\Invoice\Data\Item();

    $item->description = 'A new currency';
    $item->quantity = 5;
    $item->name = 'Bitcoin';
    $item->unitPrice = 2031.23;

    $paymentInfoDate = new \PrettyPdf\Partials\Invoice\Data\PaymentInfo();

    $paymentInfoDate->title = 'A really good title';
    $paymentInfoDate->description = 'A long description comes in here';
    $paymentInfoDate->bank = 'ING';
    $paymentInfoDate->bic = 'BICXXX';
    $paymentInfoDate->iban = 'DE42 4242 4242 4242 4242 24';
    $paymentInfoDate->name = 'Beauty Bill Creator';

    $bill = new \PrettyPdf\PrettyPdf();

    $bill->logo('/path/to/your/logo.png')
            ->headerInfoBox(['1600 Pennsylvania Ave NW', 'Washington', 'DC 20500', 'United States', 'Beauty Bill Package', 'info@drnielsen.de'])
            ->returnAddress('Dr. Schwadam, Schwinterfeldschraße 99, 10777 Berlin, Germany')
            ->receiverAddress(['Michael Jackson', 'Colorado Hippo Zoo', '5225 Figueroa Mountain Rd', 'Los Olivos', 'CA 93441', 'United States'])
            ->invoiceBox(['Date' => 'Today', 'Invoice' => 'I 2020-03-22', 'Tax-Number' => '18/455/12345'])
            ->items([$item], 19)
            ->paymentInfo($paymentInfoDate)
            ->additionalNote('Optioanl note. Nothing important here.')
            ->output('/path/where/you/want/to/store/file.pdf');
            
```

## Methods

Most important function is the [output function](http://www.fpdf.org/en/doc/output.htm)
which renders the pdf, either by saving
it as a file or by viewing the PDF in the browser, or
save it as a string.

You can call all other functions from [FPDF](http://www.fpdf.org).

In addition, the following functions are available:


| Methods               | Description |
| :-------------  | :-----|
| localize('en')     | Set language of document. Currently only English (en) and German (de) is supported. Feel free to add more languages to the repository, merge requests are welcome.  |
| setLocalizationPath(/full/path/)      |    Full path to your custom localization files, if you don't want to use the repositorie ones.  |
| logo(/full/path/logo.png) | Adds the logo to your pdf to the top left corner.  |
| receiverAdress(['Max Musterman', 'Victoria Luise Platz 97', '10777 Berlin', 'Germany') | Address of document. Height will be adjustet so that it fits on the envelope. Each entry of the array has its own line.  |
| returnAddress('My home address, Germany 121212') |Return address. Will be written as single line above address. |
| invoiceBox(['Date' => 'Today', 'Invoice' => 'I 2020-03-22', 'Tax-Number' => '18/455/12345']) | Will add a little box with heading "Invoice" right from the address.|
| headerInfoBox(['Max Mastermind', 'Your Adress', 'New York']) | Your address in the top right corner. |
| items([$itemA, $itemB, $itemC], $vat) | Receives an array (or any iterable object) of `\BeautyBill\Partials\Body\Data\Item` objects and the VAT in percent. For example, in Germany we have 19% VAT, so 19 has to be passed as a parameter. Each represents a row of your invoice |
| paymentInfo($paymentInfoData) |  Receives an object of `\BeautyBill\Partials\Body\Data\PaymentInfo`. This will create an info how to pay on the lower left side. | 
| additionalNote(string $text) | Showes a note for special rules that apply to invoice. Note appears on the lower right side. | 

## How can I add my own styling?

Simply create a class that extends `PrettyPdf\Partials\Drawable`. 

```php 
<?php 

namespace MyApp\Styles;

class MyOwnStyle extends \PrettyPdf\Partials\Drawable
{
    public function draw(): void 
    {
        // Here you can use all functions from http://www.fpdf.org/ 
        // to draw on your pdf.
        $this->MultiCell(....);
        $this->Cell(...);
        $this->Rect(..);
        
    }
}
```
Next, you need to register your class or classes to `PrettyPdf`:

```php 
$prettyPdf = new \PrettyPdf\PrettyPdf();

$prettyPdf->addCustomPartials(['\MyApp\Styles\MyOwnStyle']);
```

Now you can use the method by simply calling the classname on `$prettyPdf`:

```php 
$prettyPdf->myOwnStyle()
          ->output('/path/to/file.pdf');   
```



## How does testing work?

A pdf will be created during the test and compared to
an existing pdf. Since comparing pdf documents is not feasible,
since the file itself contain meta-data that are always distinct, 
our tests convert the pdf to an image and compare the images.

Thus, we require for testing the ImageMagic and GD library.
To make your life easier, this package ships with a docker file.

You may use it like this:

```
docker-compose up -d --build
```

Next, go inside the container to install composer and run phpunit: 

```
docker-compose exec app bash
composer install
php vendor/bin/phpunit
```

Create a test class that extends from  BeautyBillTestCase.

Here is an example:

```php 
<?php

namespace Tests;

use BeautyBill\Partials\Body\Item;

class BeautyBillBodyTest extends BeautyBillTestCase
{
    public function test_body_basic()
    {
        $this->storeOnly = true;
        
        $item = new Item();
        
        $item->description = 'A new currency';
        $item->quantity = 5;
        $item->title = 'Bitcoin';
        $item->unitPrice = 2031.23;

        $this->bill->items([$item]);
        
        $this->assertEqualPDFs('Test.pdf');
    }
}
```

When `storeOnly` is set to true, it will not compare pdfs but
just store the pdf in `Test.pdf` or whatever name you put in the method
`assertEqualPDFs`. Once the pdf looks as you want to have it,
you may remove the `storeOnly` line.
