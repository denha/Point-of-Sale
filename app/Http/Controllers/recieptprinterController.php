<?php 
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
 use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
 use App\companys;

 class recieptprinterController extends Controller{

public function reciept(){

    $branchid=auth()->user()->branchid;
    $datacompany=companys::find($branchid);
    
// Set params
$mid = '123123456';
$store_name = $datacompany->name;
$store_address = $datacompany->location;
$store_phone = $datacompany->phone;
$store_email = $datacompany->email;
$store_website = 'yourmart.com';
$tax_percentage = 10;
$transaction_id = 'TX123ABC456';

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
$printer->setCashPaid(400000,50000,"Denis"); // cashpaid // Bal/ Servered by

// Set transaction ID
//$printer->setTransactionID($transaction_id);

// Set qr code
/*$printer->setQRcode([
    'tid' => $transaction_id,
]);*/

// Print receipt
$printer->printReceipt();

}

}