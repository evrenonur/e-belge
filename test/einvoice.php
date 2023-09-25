<?php

require_once __DIR__ . '/../vendor/autoload.php';

$fatura = new \Evrenonur\EFatura();

$fatura->info(
    profileId: 'TEMELFATURA',
    itemType: 'SATIS',
    note: 'Dört Yüz Elli Altı Türk Lirası',
    currency: 'TRY',
    issueDate: '2023-09-01',
    issueTime: '12:00:00',
    lineCount: 1
);
$fatura->additionalDocumentReference("base64xslt");
$fatura->accountingSupplierParty(
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
    mail:'mail@mail.com'
);
$fatura->accountingCustomerParty(
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
    mail:'mail@mail.com'
);
$fatura->paymentTerms();
$fatura->taxExchangeRate();
$fatura->pricingExchangeRate();
$fatura->paymentExchangeRate();
$fatura->paymentAlternativeExchangeRate();
$fatura->legalMonetaryTotal(
    lineExtensionAmount: '1600.00',//Toplam Satır Tutarı
    taxExclusiveAmount: '1600.00',//Toplam Satır Tutarı
    taxInclusiveAmount: '2013.20',//Vergiler Dahil Toplam Tutar
    allowanceTotalAmount: '10.00', //Toplam İskonto Tutarı
    chargeTotalAmount: '150.00',//Arttırım Tutarı
    payableAmount: '1913.20',//Ödenecek Tutar
);
$taxSubtotals = [
    [
        'taxableAmount' => '740',
        'taxAmount' => '133.20',
        'percent' => '20.00',
        'exemptionReasonCode' => '351',
        'exemptionReason' => '351 İstisna Olmayan Diğer',
        'taxSchemeName' => 'KDV',
        'taxTypeCode' => '0015',
        'currency' => 'TRY',
    ]
];

$fatura->createTaxTotal(
    taxAmount: '133.20',
    taxSubtotals: $taxSubtotals,
);

$fatura->createWithholdingTaxTotal(
    taxAmount: '133.20',
    taxSubtotals: $taxSubtotals,
);

$item1 = $fatura->createInvoiceLine(
    id: '1',
    unitCode: 'C62',
    invoicedQuantity: '2.0000',
    lineExtensionAmount: '146.00',
    allowanceChargeData: [
        'chargeIndicator' => 'false',
        'allowanceChargeReason' => '',
        'multiplierFactorNumeric' => '0.2700',
        'amount' => '54',
    ],
    itemName: 'Stok Adı',
    priceAmount: '100.000000000000'
);
$fatura->createTaxTotal(
    taxAmount: '133.20',
    taxSubtotals: $taxSubtotals,
    element: $item1,
);

$fatura->createWithholdingTaxTotal(
    taxAmount: '133.20',
    taxSubtotals: $taxSubtotals,
    element: $item1,
);

$item2 = $fatura->createInvoiceLine(
    id: '2',
    unitCode: 'C62',
    invoicedQuantity: '2.0000',
    lineExtensionAmount: '146.00',
    allowanceChargeData: [
        'chargeIndicator' => 'false',
        'allowanceChargeReason' => '',
        'multiplierFactorNumeric' => '0.2700',
        'amount' => '54',
    ],
    itemName: 'Stok Adı',
    priceAmount: '100.000000000000'
);
$fatura->createTaxTotal(
    taxAmount: '133.20',
    taxSubtotals: $taxSubtotals,
    element: $item2,
);


header('Content-Type: text/xml');
echo $fatura->toXml();

