<?php

require_once __DIR__ . '/../vendor/autoload.php';

$fatura = new \Evrenonur\EIrsaliye();

$fatura->info(
    profileId: 'TEMELIRSALIYE',
    itemType: 'SEVK',
    issueDate: '2023-09-01',
    issueTime: '12:00:00',
    lineCount: 1
);
$fatura->additionalDocumentReference("base64xslt");
$fatura->despatchSupplierParty(
    webSite: 'https://www.onurkucukkece.com',
    vkn: '9000068418',
    ticaretSicilNo: '0',
    mersisNo: '0',
    name: 'Uyumsoft',
    adres: 'Uyumsoft Plaza',
    ilce: 'Ümraniye',
    il: 'İstanbul',
    postakodu: '34762',
    ulke: 'Türkiye',
    vergiDairesi: 'Ümraniye VD',
    telefon: '0216 999 99 99',
    fax: '0216 999 99 99',
    mail: 'mail@mail.com'
);
$fatura->deliveryCustomerParty(
    webSite: 'https://www.onurkucukkece.com',
    vkn: '9000068418',
    name: 'Uyumsoft',
    adres: 'Uyumsoft Plaza',
    ilce: 'Ümraniye',
    il: 'İstanbul',
    postakodu: '34762',
    ulke: 'Türkiye',
    vergiDairesi: 'Ümraniye VD',
    telefon: '0216 999 99 99',
    fax: '0216 999 99 99',
    mail: 'mail@mail.com'
);
$fatura->createShipment(
    shipmentID: 1,
    valueAmount: 0,
    licensePlateID: '34ABC123',
    driverFirstName: 'Onur',
    driverFamilyName: 'Evren',
    driverNationalityID: '12345678901',
    carrierVKN: '9000068418',
    carrierName: 'Uyumsoft',
    citySubdivisionName: 'Ümraniye',
    cityName: 'İstanbul',
    countryName: 'Türkiye',
    despatchDate: '2023-09-01',
    despatchTime: '12:00:00',
    transportEquipmentIDs: ['34ABC123', '34ABC124'],
);

$fatura->addDespatchLine(
    lineID: 1,
    note: 'Not',
    deliveredQuantity: 15.00,
    deliveredQuantityUnitCode: '26',
    outstandingQuantity: 0.00,
    outstandingQuantityUnitCode: '26',
    oversupplyQuantity: 0.00,
    oversupplyQuantityUnitCode: '26',
    orderLineReferenceLineID: null,
    shipmentID: 'HASH ID',
    invoiceLineID: 1,
    invoicedQuantity: 0,
    lineExtensionAmount: 45.00,
    itemWithinInvoiceLineName: null,
    priceAmount: 3.00,
    itemName: 'Mal 1',
    additionalItemIdentification: [[
        'id' => 'Kod Tipi',
        'value' => 'Kod Değeri'
    ]
    ],
    itemDescription: 'Mal 1 Açıklama',
    brandName: 'Marka 1',
    buyersItemIdentification: 'Alıcı Kodu',
    sellersItemIdentification: 'Satıcı Kodu',
);


header('Content-Type: text/xml');
echo $fatura->toXml();

