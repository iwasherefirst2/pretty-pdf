# BeautyBill

This package is build on TFPDF. 

# Methods

| Methods               | Description |
| :-------------  | :-----|
| locale('en')     | Set language of document. Currently only is supported. Add a new languagefile in Localization folder.  |
| col 2 is      | centered      |   $12 |
| zebra stripes | are neat      |    $1 |


# How does testing work?

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
