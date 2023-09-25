

# EFatura Oluşturma

XML formatında e-fatura fatura oluşturma

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


```

## Geri Bildirim

Herhangi bir geri bildiriminiz varsa, lütfen onur.evren.1999@gmail.com adresinden bana ulaşın.


## Lisans

[MIT](https://choosealicense.com/licenses/mit/)

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)