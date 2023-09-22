<?php
use Evrenonur\EInvoice;
require_once 'vendor/autoload.php';


$invoice = new EInvoice(isPerson: false);
$basicInformation = $invoice->basicInformation(
    profileId: 1,
    id: 1,
    issueDate: '2021-09-01',
    issueTime: '12:00:00',
    invoiceTypeCode: 'SATIS',
    note: 'Yalnız #Dört Yüz Elli Altı Türk Lirası# Altmış Kuruş',
    documentCurrencyCode: 'TRY',
    taxCurrencyCode: 'TRY',
    pricingCurrencyCode: 'TRY',
    paymentCurrencyCode: 'TRY',
    paymentAlternativeCurrencyCode: 'TRY',
    lineCountNumeric: 1
);
$additionalDocumentReference = $invoice->additionalDocumentReference(
    id: 1,
    issueDate: '2021-09-01',
    documentType: 'XSLT',
    base64EncodedXslt: 'base64EncodedXslt',
    filename: 'filename',
);
$accountingSupplierParty = $invoice->accountingSupplierParty(
    websiteUri: 'https://www.onur.com.tr',
    vkn: '35935923964',
    ticaretSicilNo: '123456',
    mersisNo: '1234567890123456',
    name: 'Onur Yazılım',
    streetName: 'Kızılırmak Mah. 1453 Sok. No: 1',
    citySubdivisionName: 'Çankaya',
    cityName: 'Ankara',
    postalZone: '06520',
    region: 'TR',
    countryName: 'Ankara',
    taxSchemeName: 'Mamak Vergi Dairesi',
    telephone: '0312 123 45 67',
    telefax: '0312 123 45 67',
    electronicMail: 'mail@mail.com'
);
$accountingCustomerParty = $invoice->accountingCustomerParty(
    websiteUri: 'https://www.evren.com.tr',
    vkn: '111111111',
    room: '',
    streetName: 'Kızılırmak Mah. 1453 Sok. No: 1',
    buildingName: 'Bina',
    buildingNumber: '1',
    citySubdivisionName: 'Çankaya',
    cityName: 'Ankara',
    postalZone: '06520',
    region: 'TR',
    countryName: 'Ankara',
    taxSchemeName: 'Mamak Vergi Dairesi',
    telephone: '0312 123 45 67',
    telefax: '0312 123 45 67',
    electronicMail: 'mail@mail.com',
    firstName: 'Okan', familyName: 'Evren',
);
$paymentTerms = $invoice->paymentTerms(
    note: '#Ya#',
    penaltySurchargePercent: 18,
    amount: 100,
    currencyID: 'TRY',
);
$taxExchangeRate = $invoice->taxExchangeRate(
    sourceCurrencyCode: 'TRY',
    targetCurrencyCode: 'TRY',
    calculationRate: 1,
    date: '2021-09-01',
);
$pricingExchangeRate = $invoice->pricingExchangeRate(
    sourceCurrencyCode: 'TRY',
    targetCurrencyCode: 'TRY',
    calculationRate: 1,
    date: '2021-09-01',
);
$paymentExchangeRate = $invoice->paymentExchangeRate(
    sourceCurrencyCode: 'TRY',
    targetCurrencyCode: 'TRY',
    calculationRate: 1,
    date: '2021-09-01',
);

$paymentAlternativeExchangeRate = $invoice->paymentAlternativeExchangeRate(
    sourceCurrencyCode: 'TRY',
    targetCurrencyCode: 'TRY',
    calculationRate: 1,
    date: '2021-09-01',
);

$legalMonetaryTotal = $invoice->legalMonetaryTotal(
    lineExtensionAmount: 100,
    taxExclusiveAmount: 100,
    taxInclusiveAmount: 100,
    allowanceTotalAmount: 100,
    chargeTotalAmount: 100,
    payableAmount: 100,
);

$taxTotalElement = $invoice->taxTotal(
    null,
    taxAmount: 100,
    currencyID: 'USD'
);
$subTaxTotalElement = $invoice->subTaxTotal(
    $taxTotalElement,
    taxableAmount: 100,
    taxAmount: 100,
    percent: 18,
    currencyID: 'USD',
    taxCategory: [
        'taxExemptionReasonCode' => '123',
        'taxExemptionReason' => 'Some Reason',
        'taxSchemeName' => 'KDV',
        'taxSchemeCode' => '0015',
    ]
);


$witholdingTaxTotalElement = $invoice->withholdingTaxTotal(
    invoiceElement: null,
    taxAmount: 100,
    currencyID: 'USD',
);
$subTaxTotalElement = $invoice->subTaxTotal(
    $witholdingTaxTotalElement,
    taxableAmount: 100,
    taxAmount: 100,
    percent: 18,
    currencyID: 'USD',
    taxCategory: [
        'taxExemptionReasonCode' => '123',
        'taxExemptionReason' => 'Some Reason',
        'taxSchemeName' => 'KDV',
        'taxSchemeCode' => '0015',
    ]
);

$invoiceLine1 = $invoice->addInvoiceLine(
    lineID: 1,
    invoicedQuantity: 1,
    unitCode: 'C62',
    lineExtensionAmount: 100,
    currencyID: 'USD',
    itemName: 'Test Item',
    priceAmount: 100,
);

$allowanceCharge = $invoice->allowanceCharge(
    invoiceElement: $invoiceLine1,
    chargeIndicator: false,
    allowanceChargeReason: 'Test Reason',
    multiplierFactorNumeric: 1,
    amount: 100,
    currencyID: 'USD',
);


$taxTotalElement = $invoice->taxTotal(
    $invoiceLine1,
    taxAmount: 100,
    currencyID: 'USD'
);
$subTaxTotalElement = $invoice->subTaxTotal(
    $taxTotalElement,
    taxableAmount: 100,
    taxAmount: 100,
    percent: 18,
    currencyID: 'USD',
    taxCategory: [
        'taxExemptionReasonCode' => '123',
        'taxExemptionReason' => 'Some Reason',
        'taxSchemeName' => 'KDV',
        'taxSchemeCode' => '0015',
    ]
);

$witholdingTaxTotalElement = $invoice->withholdingTaxTotal(
    invoiceElement: $invoiceLine1,
    taxAmount: 100,
    currencyID: 'USD',
);
$subTaxTotalElement = $invoice->subTaxTotal(
    $witholdingTaxTotalElement,
    taxableAmount: 100,
    taxAmount: 100,
    percent: 18,
    currencyID: 'USD',
    taxCategory: [
        'taxExemptionReasonCode' => '123',
        'taxExemptionReason' => 'Some Reason',
        'taxSchemeName' => 'KDV',
        'taxSchemeCode' => '0015',
    ]
);

echo $invoice->toXML();