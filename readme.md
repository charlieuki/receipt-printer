# Laravel Receipt Printer

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Simple Laravel package to integrate ESC/POS Print Driver for PHP.

## Installation

Via Composer

``` bash
$ composer require charlieuki/receiptprinter
```

## Sample App

I have set up [a simple app](https://github.com/charlieuki/receipt-printer-example) based on Laravel 7 to serve as a demo.

## Usage

Execute the following command to publish the config used by this package:

```
$ php artisan vendor:publish --tag=receiptprinter.config
```

Edit the config file located at `config/receiptprinter.php` as follows:

1. Set `connector_type` to:
    - `windows` if you are using Windows as your web server.
    - `cups` if you are using Linux or Mac as your web server.
    - `network` if you are using a network printer.
2. Set `connector_descriptor` to:
    - the printer name if your `connector_type` is either `windows` or `cups`
    - the IP address or Samba URI, e.g: `smb://192.168.0.5/PrinterName` if your `connector_type` is `network`
3. Set `connector_port` to the open port for the printer, only if your `connector_type` is `network`

Include the library:

```
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
```

Then use any one of these two functions to send "print" command to the printer.

```
printReceipt()
```

```
printRequest()
```

## Example (Print Receipt)

```
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

...

// Set params
$mid = '123123456';
$store_name = 'YOURMART';
$store_address = 'Mart Address';
$store_phone = '1234567890';
$store_email = 'yourmart@email.com';
$store_website = 'yourmart.com';
$tax_percentage = 10;
$transaction_id = 'TX123ABC456';
$currency = 'Rp';

// Set items
$items = [
    [
        'name' => 'French Fries (tera)',
        'qty' => 2,
        'price' => 65000,
    ],
    [
        'name' => 'Roasted Milk Tea (large)',
        'qty' => 1,
        'price' => 24000,
    ],
    [
        'name' => 'Honey Lime (large)',
        'qty' => 3,
        'price' => 10000,
    ],
    [
        'name' => 'Jasmine Tea (grande)',
        'qty' => 3,
        'price' => 8000,
    ],
];

// Init printer
$printer = new ReceiptPrinter;
$printer->init(
    config('receiptprinter.connector_type'),
    config('receiptprinter.connector_descriptor')
);

// Set store info
$printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

// Set currency
$printer->setCurrency($currency);

// Add items
foreach ($items as $item) {
    $printer->addItem(
        $item['name'],
        $item['qty'],
        $item['price']
    );
}
// Set tax
$printer->setTax($tax_percentage);

// Calculate total
$printer->calculateSubTotal();
$printer->calculateGrandTotal();

// Set transaction ID
$printer->setTransactionID($transaction_id);

// Set qr code
$printer->setQRcode([
    'tid' => $transaction_id,
]);

// Print receipt
$printer->printReceipt();
```

## Example (Print Request)

```
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

...

// Set params
$mid = '123123456';
$store_name = 'YOURMART';
$store_address = 'Mart Address';
$store_phone = '1234567890';
$store_email = 'yourmart@email.com';
$store_website = 'yourmart.com';
$tax_percentage = 10;
$transaction_id = 'TX123ABC456';
$currency = 'Rp';

// Init printer
$printer = new ReceiptPrinter;
$printer->init(
    config('receiptprinter.connector_type'),
    config('receiptprinter.connector_descriptor')
);

// Set store info
$printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

// Set currency
$printer->setCurrency($currency);

// Set request amount
$printer->setRequestAmount($request_amount);

// Set transaction ID
$printer->setTransactionID($transaction_id);

// Set qr code
$printer->setQRcode([
    'tid' => $transaction_id,
    'amount' => $request_amount,
]);

// Print payment request
$printer->printRequest();
```

## Changelog

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Problems

If you discover any issues, please post the details on the [issue tracker](https://github.com/charlieuki/receipt-printer/issues).

## Credits

- *Mike42* for the awesome [PHP ESC/POS Print Driver](https://github.com/mike42/escpos-php "PHP ESC/POS Print Driver") library

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/charlieuki/receiptprinter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/charlieuki/receiptprinter.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/charlieuki/receiptprinter/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/charlieuki/receiptprinter
[link-downloads]: https://packagist.org/packages/charlieuki/receiptprinter
[link-travis]: https://travis-ci.org/charlieuki/receiptprinter
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/charlieuki
[link-contributors]: ../../contributors
