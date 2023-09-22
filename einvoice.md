

# E Arşiv Fatura Oluşturma

XML formatında e arşiv fatura oluşturma

-   **basicInformation**: Faturaya temel bilgileri ekler, bu bilgiler arasında sürüm, profil kimliği, düzenleme tarihi ve para birimi kodları bulunur.

-   **additionalDocumentReference**: Faturaya ek belge referansları ekler, bu belgelere ekler gibi ekler.

-   **accountingSupplierParty:** Tedarikçi veya satıcı hakkında detayları ekler, bu detaylar arasında iletişim bilgileri ve vergi ile ilgili detaylar bulunur.

-   **accountingCustomerParty**: Müşteri veya alıcı hakkında detayları ekler, bu detaylar arasında iletişim bilgileri ve vergi ile ilgili detaylar bulunur.

-   **paymentTerms**: Fatura için ödeme koşullarını belirler, bu koşullar arasında notlar ve para birimi detayları bulunur.

-   **taxExchangeRate, pricingExchangeRate, paymentExchangeRate, paymentAlternativeExchangeRate**: Vergiler, fiyatlandırma, ödemeler ve alternatif ödemeler için döviz kurlarını tanımlar.

-   **legalMonetaryTotal**: Fatura için yasal para toplamını belirtir, bu toplamlar arasında satır genişletme tutarı, vergi tutarı ve ödenecek tutar gibi çeşitli miktarlar bulunur.

-  **taxTotal**: Fatura ile ilgili vergi bilgilerini ekler, bu bilgilere vergi tutarı ve para birimi dahildir.

-   **subTaxTotal**: Vergiler için alt toplamları ekler ve bu toplamlarda vergilendirilebilir miktar, vergi miktarı ve vergi kategorisi gibi detaylar bulunur.

-   **withholdingTaxTotal**: Vergi kesintisi bilgilerini belirtir.

-  **allowanceCharge**: Faturaya indirim veya ek ücretler ekler.

-   **addInvoiceLine**: Her fatura satırı için detayları ekler, bu detaylar arasında satır kimliği, miktar, birim kodu, satır genişletme tutarı, ürün adı ve fiyat tutarı bulunur.
![Build](https://img.shields.io/badge/build-passing-brightgreen)




## Kurulum

```
composer require evrenonur/e-belge
```


## Kullanım
```php
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
```

## Geri Bildirim

Herhangi bir geri bildiriminiz varsa, lütfen onur.evren.1999@gmail.com adresinden bana ulaşın.


## Lisans

[MIT](https://choosealicense.com/licenses/mit/)

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)