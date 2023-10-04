<?php
namespace Evrenonur;
class EFatura
{

    protected $xml;

    public function __construct()
    {
        $this->xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>' .
            '<Invoice xmlns:ubltr="urn:oasis:names:specification:ubl:schema:xsd:TurkishCustomizationExtensionComponents"
                                     xmlns:cctc="urn:un:unece:uncefact:documentation:2"
                                     xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
                                     xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
                                     xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2"
                                     xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
                                     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                     xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
                                     xmlns:xades="http://uri.etsi.org/01903/v1.3.2#"
                                     xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2"
                                     xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 UBL-Invoice-2.1.xsd"
                                     xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"></Invoice>');
    }

    public function info($profileId,$itemType,$note,$currency,$issueDate,$issueTime,$lineCount): void
    {
        $this->xml->addChild('cbc:UBLVersionID', '2.1', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:CustomizationID', 'TR1.2', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:ProfileID', $profileId, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:ID', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:CopyIndicator', 'false', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:UUID', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:IssueDate', $issueDate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:IssueTime', $issueTime, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:InvoiceTypeCode', $itemType, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:Note', 'Yalnız #'.$note.'#', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:DocumentCurrencyCode', $currency, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:TaxCurrencyCode', $currency, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:PricingCurrencyCode', $currency, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:PaymentCurrencyCode', $currency, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:PaymentAlternativeCurrencyCode', $currency, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:LineCountNumeric', $lineCount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }
    public function additionalDocumentReference ($value): void
    {
        $additionalDocumentReference = $this->xml->addChild('cac:AdditionalDocumentReference');
        // İçerik eklemek için gerekli alt öğeleri ekleyin
        $additionalDocumentReference->addChild('cbc:ID', '070925c3-fd68-49be-9380-bea891e0ac7f', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $additionalDocumentReference->addChild('cbc:IssueDate', '2019-12-12', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $additionalDocumentReference->addChild('cbc:DocumentType', 'Xslt', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        // Attachment öğesini ekleyin
        $attachment = $additionalDocumentReference->addChild('cac:Attachment');
        // Attachment öğesine gerekli alt öğeleri ekleyin
        $embeddedDocumentBinaryObject = $attachment->addChild('cbc:EmbeddedDocumentBinaryObject', $value, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $embeddedDocumentBinaryObject->addAttribute('mimeCode', 'application/xml');
        $embeddedDocumentBinaryObject->addAttribute('encodingCode', 'Base64');
        $embeddedDocumentBinaryObject->addAttribute('characterSetCode', 'UTF-8');
        $embeddedDocumentBinaryObject->addAttribute('filename', uniqid() .'.xslt');
    }
    public function accountingSupplierParty($webSite,$vkn,$ticaretSicilNo ,$mersisNo,$name,$adres,$ilce,$il,$postakodu = null,$ulke= null,$vergiDairesi= null,$telefon= null,$fax= null,$mail= null): void
    {
        $accountingSupplierParty = $this->xml->addChild('cac:AccountingSupplierParty', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        // Party öğesi
        $party = $accountingSupplierParty->addChild('cac:Party', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        $party->addChild('cbc:WebsiteURI', $webSite, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PartyIdentification öğeleri
        $partyIdentification1 = $party->addChild('cac:PartyIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification1->addChild('cbc:ID', $vkn, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'VKN');

        $partyIdentification2 = $party->addChild('cac:PartyIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification2->addChild('cbc:ID', $ticaretSicilNo, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'TICARETSICILNO');

        $partyIdentification3 = $party->addChild('cac:PartyIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification3->addChild('cbc:ID', $mersisNo, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'MERSISNO');

        // PartyName öğesi
        $partyName = $party->addChild('cac:PartyName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyName->addChild('cbc:Name', $name, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PostalAddress öğesi
        $postalAddress = $party->addChild('cac:PostalAddress', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $postalAddress->addChild('cbc:Room', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:StreetName', $adres, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingNumber', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CitySubdivisionName', $ilce, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CityName', $il, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:PostalZone', $postakodu, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:Region', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Country öğesi
        $country = $postalAddress->addChild('cac:Country', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $country->addChild('cbc:Name', $ulke, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PartyTaxScheme öğesi
        $partyTaxScheme = $party->addChild('cac:PartyTaxScheme', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyTaxScheme->addChild('cac:TaxScheme', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2')->addChild('cbc:Name', $vergiDairesi, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Contact öğesi
        $contact = $party->addChild('cac:Contact', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $contact->addChild('cbc:Telephone', $telefon, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:Telefax', $fax, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:ElectronicMail', $mail, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }
    public function accountingCustomerParty($webSite,$vkn,$name,$adres,$ilce,$il,$postakodu = null,$ulke= null,$vergiDairesi= null,$telefon= null,$fax= null,$mail= null)
    {
        $accountingCustomerParty = $this->xml->addChild('cac:AccountingCustomerParty', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        // Party öğesi
        $party = $accountingCustomerParty->addChild('cac:Party', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        $party->addChild('cbc:WebsiteURI', $webSite, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PartyIdentification öğesi
        $partyIdentification = $party->addChild('cac:PartyIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification->addChild('cbc:ID', $vkn, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'VKN');

        // PartyName öğesi
        $partyName = $party->addChild('cac:PartyName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyName->addChild('cbc:Name', $name, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PostalAddress öğesi
        $postalAddress = $party->addChild('cac:PostalAddress', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $postalAddress->addChild('cbc:Room', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:StreetName', $adres, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingNumber', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CitySubdivisionName', $ilce, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CityName', $il, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:PostalZone', $postakodu, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:Region', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Country öğesi
        $country = $postalAddress->addChild('cac:Country', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $country->addChild('cbc:Name', $ulke, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PartyTaxScheme öğesi
        $partyTaxScheme = $party->addChild('cac:PartyTaxScheme', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyTaxScheme->addChild('cac:TaxScheme', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2')->addChild('cbc:Name', $vergiDairesi, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Contact öğesi
        $contact = $party->addChild('cac:Contact', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $contact->addChild('cbc:Telephone', $telefon, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:Telefax', $fax, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:ElectronicMail', $mail, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }

    public function buyerCustomerParty($webSite,$vkn,$name,$adres,$ilce,$il,$postakodu = null,$ulke= null,$vergiDairesi= null,$telefon= null,$fax= null,$mail= null)
    {
        $accountingCustomerParty = $this->xml->addChild('cac:BuyerCustomerParty', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        // Party öğesi
        $party = $accountingCustomerParty->addChild('cac:Party', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        // PartyIdentification öğesi
        $partyIdentification = $party->addChild('cac:PartyIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification->addChild('cbc:ID', "EXPORT", 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'PARTYTYPE');

        // PartyName öğesi
        $partyName = $party->addChild('cac:PartyName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyName->addChild('cbc:Name', $name, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PostalAddress öğesi
        $postalAddress = $party->addChild('cac:PostalAddress', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $postalAddress->addChild('cbc:Room', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:StreetName', $adres, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingNumber', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CitySubdivisionName', $ilce, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CityName', $il, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:PostalZone', $postakodu, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:Region', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Country öğesi
        $country = $postalAddress->addChild('cac:Country', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $country->addChild('cbc:Name', $ulke, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $partyLegalEntity = $party->addChild('cac:PartyLegalEntity', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyLegalEntity->addChild('cbc:RegistrationName', $name, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $partyLegalEntity->addChild('cbc:CompanyID', $vkn, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Contact öğesi
        $contact = $party->addChild('cac:Contact', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $contact->addChild('cbc:Telephone', $telefon, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:Telefax', $fax, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:ElectronicMail', $mail, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }
    public function paymentTerms($not = null,$penaltySurchargePercent = 0,$amount = 0,$currency = 'TRY')
    {
        $paymentTerms = $this->xml->addChild('cac:PaymentTerms', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $paymentTerms->addChild('cbc:Note', $not, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentTerms->addChild('cbc:PenaltySurchargePercent', $penaltySurchargePercent, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentTerms->addChild('cbc:Amount', $amount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currency);
    }
    public function taxExchangeRate($sourceCurrencyCode = 'TRY',$targetCurrencyCode = 'TRY',$calculationRate = 0.00000000,$date = null)
    {
        $taxExchangeRate = $this->xml->addChild('cac:TaxExchangeRate', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxExchangeRate->addChild('cbc:SourceCurrencyCode', $sourceCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxExchangeRate->addChild('cbc:TargetCurrencyCode', $targetCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxExchangeRate->addChild('cbc:CalculationRate', $calculationRate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxExchangeRate->addChild('cbc:Date', $date == null ? date('Y-m-d') : $date, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }
    public function pricingExchangeRate($sourceCurrencyCode = 'TRY',$targetCurrencyCode = 'TRY',$calculationRate = 0.00000000,$date = null)
    {
        $pricingExchangeRate = $this->xml->addChild('cac:PricingExchangeRate', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $pricingExchangeRate->addChild('cbc:SourceCurrencyCode', $sourceCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $pricingExchangeRate->addChild('cbc:TargetCurrencyCode', $targetCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $pricingExchangeRate->addChild('cbc:CalculationRate', $calculationRate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $pricingExchangeRate->addChild('cbc:Date', $date == null ? date('Y-m-d') : $date, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }
    public function paymentExchangeRate($sourceCurrencyCode = 'TRY',$targetCurrencyCode = 'TRY',$calculationRate = 0.00000000,$date = null)
    {
        $paymentExchangeRate = $this->xml->addChild('cac:PaymentExchangeRate', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $paymentExchangeRate->addChild('cbc:SourceCurrencyCode', $sourceCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentExchangeRate->addChild('cbc:TargetCurrencyCode', $targetCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentExchangeRate->addChild('cbc:CalculationRate', $calculationRate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentExchangeRate->addChild('cbc:Date', $date == null ? date('Y-m-d') : $date, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }
    public function paymentAlternativeExchangeRate($sourceCurrencyCode = 'TRY',$targetCurrencyCode = 'TRY',$calculationRate = 0.00000000,$date = null)
    {
        $paymentAlternativeExchangeRate = $this->xml->addChild('cac:PaymentAlternativeExchangeRate', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $paymentAlternativeExchangeRate->addChild('cbc:SourceCurrencyCode', $sourceCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentAlternativeExchangeRate->addChild('cbc:TargetCurrencyCode', $targetCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentAlternativeExchangeRate->addChild('cbc:CalculationRate', $calculationRate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentAlternativeExchangeRate->addChild('cbc:Date', $date == null ? date('Y-m-d') : $date, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }

    public function legalMonetaryTotal($lineExtensionAmount, $taxExclusiveAmount, $taxInclusiveAmount, $allowanceTotalAmount, $chargeTotalAmount, $payableAmount,$currency = 'TRY')
    {
        $legalMonetaryTotal = $this->xml->addChild('cac:LegalMonetaryTotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $legalMonetaryTotal->addChild('cbc:LineExtensionAmount', $lineExtensionAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currency);
        $legalMonetaryTotal->addChild('cbc:TaxExclusiveAmount', $taxExclusiveAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currency);
        $legalMonetaryTotal->addChild('cbc:TaxInclusiveAmount', $taxInclusiveAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currency);
        $legalMonetaryTotal->addChild('cbc:AllowanceTotalAmount', $allowanceTotalAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currency);
        $legalMonetaryTotal->addChild('cbc:ChargeTotalAmount', $chargeTotalAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currency);
        $legalMonetaryTotal->addChild('cbc:PayableAmount', $payableAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currency);
    }

    public function createTaxTotal($taxAmount,$taxSubtotals,$element = null,$currency = 'TRY')
    {
        if ($element == null)
            $taxTotal = $this->xml->addChild('cac:TaxTotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        else
            $taxTotal = $element->addChild('cac:TaxTotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxTotal->addChild('cbc:TaxAmount', $taxAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')
            ->addAttribute('currencyID', $currency);
        foreach ($taxSubtotals as $taxSubtotalData) {
            $this->createTaxSubtotal($taxTotal, $taxSubtotalData);
        }
    }

    public function createWithholdingTaxTotal($taxAmount,$taxSubtotals,$element = null,$currency = 'TRY')
    {
        if ($element == null)
            $taxTotal = $this->xml->addChild('cac:WithholdingTaxTotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        else
            $taxTotal = $element->addChild('cac:WithholdingTaxTotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxTotal->addChild('cbc:TaxAmount', $taxAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')
            ->addAttribute('currencyID', $currency);
        foreach ($taxSubtotals as $taxSubtotalData) {
            $this->createTaxSubtotal($taxTotal, $taxSubtotalData);
        }
    }

    public function createTaxSubtotal($parentTaxTotal, $taxSubtotalData)
    {
        $taxSubtotal = $parentTaxTotal->addChild('cac:TaxSubtotal', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxSubtotal->addChild('cbc:TaxableAmount', $taxSubtotalData['taxableAmount'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $taxSubtotalData['currency']);
        $taxSubtotal->addChild('cbc:TaxAmount', $taxSubtotalData['taxAmount'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $taxSubtotalData['currency']);
        $taxSubtotal->addChild('cbc:Percent', $taxSubtotalData['percent'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxCategory = $taxSubtotal->addChild('cac:TaxCategory', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        if (array_key_exists('exemptionReasonCode', $taxSubtotalData) && array_key_exists('exemptionReason', $taxSubtotalData)){
            if ($taxSubtotalData['exemptionReasonCode'] != null && $taxSubtotalData['exemptionReason'] != null){
                $taxCategory->addChild('cbc:TaxExemptionReasonCode', $taxSubtotalData['exemptionReasonCode'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
                $taxCategory->addChild('cbc:TaxExemptionReason', $taxSubtotalData['exemptionReason'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            }
        }
        $taxScheme = $taxCategory->addChild('cac:TaxScheme', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxScheme->addChild('cbc:Name', $taxSubtotalData['taxSchemeName'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxScheme->addChild('cbc:TaxTypeCode', $taxSubtotalData['taxTypeCode'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }


    public function createInvoiceLine($id, $unitCode, $invoicedQuantity, $lineExtensionAmount, $allowanceChargeData, $itemName, $priceAmount,$currency = 'TRY',$isExport = false,$deliveryTermId= null,$gipt = null,$transportModeCode = null)
    {
        $invoiceLine = $this->xml->addChild('cac:InvoiceLine', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $invoiceLine->addChild('cbc:ID', $id, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $invoiceLine->addChild('cbc:Note', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $invoicedQuantityElement = $invoiceLine->addChild('cbc:InvoicedQuantity', $invoicedQuantity, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $invoicedQuantityElement->addAttribute('unitCode', $unitCode);
        $invoiceLine->addChild('cbc:LineExtensionAmount', $lineExtensionAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currency);

        if ($isExport){
            $delivery = $invoiceLine->addChild('cac:Delivery', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $deliveryAdress = $delivery->addChild('cac:DeliveryAddress', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $deliveryAdress->addChild('cbc:Room', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryAdress->addChild('cbc:StreetName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryAdress->addChild('cbc:BuildingName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryAdress->addChild('cbc:BuildingNumber', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryAdress->addChild('cbc:CitySubdivisionName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryAdress->addChild('cbc:CityName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryAdress->addChild('cbc:PostalZone', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryAdress->addChild('cbc:Region', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryAdress->addChild('cbc:Region', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $country = $deliveryAdress->addChild('cac:Country', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $country->addChild('cbc:Name', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $deliveryTerms = $delivery->addChild('cac:DeliveryTerms', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $deliveryTerms->addChild('cbc:ID', $deliveryTermId, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'INCOTERMS');

            $shipment = $invoiceLine->addChild('cac:Shipment', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $shipment->addChild('cbc:ID', $id, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $goodsItem = $shipment->addChild('cac:GoodsItem', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $goodsItem->addChild('cbc:RequiredCustomsID', $gipt, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $shipmentStage = $shipment->addChild('cac:ShipmentStage', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $shipmentStage->addChild('cbc:TransportModeCode', $transportModeCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        }else{
            $allowanceCharge = $invoiceLine->addChild('cac:AllowanceCharge', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $allowanceCharge->addChild('cbc:ChargeIndicator', $allowanceChargeData['chargeIndicator'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $allowanceCharge->addChild('cbc:AllowanceChargeReason', $allowanceChargeData['allowanceChargeReason'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $allowanceCharge->addChild('cbc:MultiplierFactorNumeric', $allowanceChargeData['multiplierFactorNumeric'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $allowanceChargeAmount = $allowanceCharge->addChild('cbc:Amount', $allowanceChargeData['amount'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $allowanceChargeAmount->addAttribute('currencyID', $currency);
        }

        $item = $invoiceLine->addChild('cac:Item', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $item->addChild('cbc:Name', $itemName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $price = $invoiceLine->addChild('cac:Price', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $priceAmount = $price->addChild('cbc:PriceAmount', $priceAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $priceAmount->addAttribute('currencyID', $currency);
        return $invoiceLine;
    }

    public function toXml(): string
    {
        return $this->xml->asXML();
    }

}