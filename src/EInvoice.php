<?php
namespace Evrenonur;
class EInvoice
{

    private $invoice;
    protected $isPerson = false;

    public function __construct($isPerson)
    {
        $this->invoice = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
<EInvoice xmlns:ubltr="urn:oasis:names:specification:ubl:schema:xsd:TurkishCustomizationExtensionComponents"
         xmlns:cctc="urn:un:unece:uncefact:documentation:2"
         xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
         xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
         xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2"
         xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
         xmlns:xades="http://uri.etsi.org/01903/v1.3.2#"
         xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2"
         xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:EInvoice-2 UBL-EInvoice-2.1.xsd"
         xmlns="urn:oasis:names:specification:ubl:schema:xsd:EInvoice-2"></EInvoice>');
        $this->isPerson = $isPerson;
    }


    public function basicInformation(
        $profileId, $id, $issueDate, $issueTime,
        $invoiceTypeCode, $note, $documentCurrencyCode,
        $taxCurrencyCode, $pricingCurrencyCode, $paymentCurrencyCode,
        $paymentAlternativeCurrencyCode, $lineCountNumeric
    )
    {
        $this->invoice->addChild('cbc:UBLVersionID', '2.1', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:CustomizationID', 'TR1.2', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:ProfileID', $profileId, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:ID', $id, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:CopyIndicator', 'false', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:UUID', '2e5af691-19b4-434c-87c7-2f692a1bf810', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:IssueDate', $issueDate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:IssueTime', $issueTime, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:InvoiceTypeCode', $invoiceTypeCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:Note', $note, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:DocumentCurrencyCode', $documentCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:TaxCurrencyCode', $taxCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:PricingCurrencyCode', $pricingCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:PaymentCurrencyCode', $paymentCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:PaymentAlternativeCurrencyCode', $paymentAlternativeCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->invoice->addChild('cbc:LineCountNumeric', $lineCountNumeric, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        return $this->invoice;
    }

    public function additionalDocumentReference($id, $issueDate, $documentType, $base64EncodedXslt, $filename)
    {
        $additionalDocumentReference = $this->invoice->addChild('cac:AdditionalDocumentReference', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $additionalDocumentReference->addChild('cbc:ID', $id, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $additionalDocumentReference->addChild('cbc:IssueDate', $issueDate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $additionalDocumentReference->addChild('cbc:DocumentType', $documentType, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $attachment = $additionalDocumentReference->addChild('cac:Attachment', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $embeddedDocumentBinaryObject = $attachment->addChild('cbc:EmbeddedDocumentBinaryObject', $base64EncodedXslt, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $embeddedDocumentBinaryObject->addAttribute('mimeCode', 'application/xml');
        $embeddedDocumentBinaryObject->addAttribute('encodingCode', 'Base64');
        $embeddedDocumentBinaryObject->addAttribute('characterSetCode', 'UTF-8');
        $embeddedDocumentBinaryObject->addAttribute('filename', $filename);
        return $this->invoice;
    }

    public function accountingSupplierParty(
        $websiteUri, $vkn, $ticaretSicilNo, $mersisNo, $name,
        $streetName, $citySubdivisionName, $cityName,
        $postalZone, $region, $countryName, $taxSchemeName,
        $telephone, $telefax, $electronicMail
    )
    {
        $accountingSupplierParty = $this->invoice->addChild('cac:AccountingSupplierParty', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $party = $accountingSupplierParty->addChild('cac:Party', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $party->addChild('cbc:WebsiteURI', $websiteUri, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $partyIdentification1 = $party->addChild('cac:PartyIdentification', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification1->addChild('cbc:ID', $vkn, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'VKN');
        $partyIdentification2 = $party->addChild('cac:PartyIdentification', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification2->addChild('cbc:ID', $ticaretSicilNo, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'TICARETSICILNO');
        $partyIdentification3 = $party->addChild('cac:PartyIdentification', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification3->addChild('cbc:ID', $mersisNo, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'MERSISNO');
        $partyName = $party->addChild('cac:PartyName', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyName->addChild('cbc:Name', $name, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress = $party->addChild('cac:PostalAddress', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $postalAddress->addChild('cbc:Room', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:StreetName', $streetName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingName', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingNumber', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CitySubdivisionName', $citySubdivisionName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CityName', $cityName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:PostalZone', $postalZone, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:Region', $region, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $country = $postalAddress->addChild('cac:Country', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $country->addChild('cbc:Name', $countryName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $partyTaxScheme = $party->addChild('cac:PartyTaxScheme', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxScheme = $partyTaxScheme->addChild('cac:TaxScheme', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxScheme->addChild('cbc:Name', $taxSchemeName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact = $party->addChild('cac:Contact', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $contact->addChild('cbc:Telephone', $telephone, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:Telefax', $telefax, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:ElectronicMail', $electronicMail, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        return $this->invoice;
    }

    public function accountingCustomerParty(
        $websiteUri, $vkn, $room, $streetName, $buildingName, $buildingNumber,
        $citySubdivisionName, $cityName, $postalZone, $region, $countryName, $taxSchemeName,
        $telephone, $telefax, $electronicMail, $firstName, $familyName
    )
    {
        $accountingCustomerParty = $this->invoice->addChild('cac:AccountingCustomerParty', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $party = $accountingCustomerParty->addChild('cac:Party', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $party->addChild('cbc:WebsiteURI', $websiteUri, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $partyIdentification = $party->addChild('cac:PartyIdentification', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification->addChild('cbc:ID', $vkn, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', $this->isPerson ? 'TCKN' : 'VKN');
        $postalAddress = $party->addChild('cac:PostalAddress', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $postalAddress->addChild('cbc:Room', $room, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:StreetName', $streetName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingName', $buildingName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:BuildingNumber', $buildingNumber, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CitySubdivisionName', $citySubdivisionName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CityName', $cityName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:PostalZone', $postalZone, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:Region', $region, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $country = $postalAddress->addChild('cac:Country', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $country->addChild('cbc:Name', $countryName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        if ($this->isPerson) {
            $partyTaxScheme = $party->addChild('cac:PartyTaxScheme', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $taxScheme = $partyTaxScheme->addChild('cac:TaxScheme', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $taxScheme->addChild('cbc:Name', $taxSchemeName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        }

        $contact = $party->addChild('cac:Contact', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $contact->addChild('cbc:Telephone', $telephone, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:Telefax', $telefax, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contact->addChild('cbc:ElectronicMail', $electronicMail, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        if ($this->isPerson){
            $person = $party->addChild('cac:Person', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $person->addChild('cbc:FirstName', $firstName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $person->addChild('cbc:FamilyName', $familyName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        }else{
            $partyName = $party->addChild('cac:PartyName', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $partyName->addChild('cbc:Name', $firstName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        }
        return $this->invoice;
    }

    public function paymentTerms($note, $penaltySurchargePercent, $amount, $currencyID)
    {
        $paymentTerms = $this->invoice->addChild('cac:PaymentTerms', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $paymentTerms->addChild('cbc:Note', $note, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentTerms->addChild('cbc:PenaltySurchargePercent', $penaltySurchargePercent, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentTerms->addChild('cbc:Amount', $amount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currencyID);
        return $this->invoice;
    }

    public function taxExchangeRate($sourceCurrencyCode, $targetCurrencyCode, $calculationRate, $date)
    {
        $taxExchangeRate = $this->invoice->addChild('cac:TaxExchangeRate', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxExchangeRate->addChild('cbc:SourceCurrencyCode', $sourceCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxExchangeRate->addChild('cbc:TargetCurrencyCode', $targetCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxExchangeRate->addChild('cbc:CalculationRate', $calculationRate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxExchangeRate->addChild('cbc:Date', $date, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        return $this->invoice;
    }

    public function pricingExchangeRate($sourceCurrencyCode, $targetCurrencyCode, $calculationRate, $date)
    {
        $pricingExchangeRate = $this->invoice->addChild('cac:PricingExchangeRate', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $pricingExchangeRate->addChild('cbc:SourceCurrencyCode', $sourceCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $pricingExchangeRate->addChild('cbc:TargetCurrencyCode', $targetCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $pricingExchangeRate->addChild('cbc:CalculationRate', $calculationRate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $pricingExchangeRate->addChild('cbc:Date', $date, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        return $this->invoice;
    }

    public function paymentExchangeRate($sourceCurrencyCode, $targetCurrencyCode, $calculationRate, $date)
    {
        $paymentExchangeRate = $this->invoice->addChild('cac:PaymentExchangeRate', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $paymentExchangeRate->addChild('cbc:SourceCurrencyCode', $sourceCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentExchangeRate->addChild('cbc:TargetCurrencyCode', $targetCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentExchangeRate->addChild('cbc:CalculationRate', $calculationRate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentExchangeRate->addChild('cbc:Date', $date, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        return $this->invoice;
    }

    public function paymentAlternativeExchangeRate($sourceCurrencyCode, $targetCurrencyCode, $calculationRate, $date)
    {
        $paymentAlternativeExchangeRate = $this->invoice->addChild('cac:PaymentAlternativeExchangeRate', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $paymentAlternativeExchangeRate->addChild('cbc:SourceCurrencyCode', $sourceCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentAlternativeExchangeRate->addChild('cbc:TargetCurrencyCode', $targetCurrencyCode, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentAlternativeExchangeRate->addChild('cbc:CalculationRate', $calculationRate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $paymentAlternativeExchangeRate->addChild('cbc:Date', $date, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        return $this->invoice;
    }

    public function legalMonetaryTotal($lineExtensionAmount, $taxExclusiveAmount, $taxInclusiveAmount, $allowanceTotalAmount, $chargeTotalAmount, $payableAmount)
    {
        $legalMonetaryTotal = $this->invoice->addChild('cac:LegalMonetaryTotal', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $legalMonetaryTotal->addChild('cbc:LineExtensionAmount', $lineExtensionAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', 'TRY');
        $legalMonetaryTotal->addChild('cbc:TaxExclusiveAmount', $taxExclusiveAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', 'TRY');
        $legalMonetaryTotal->addChild('cbc:TaxInclusiveAmount', $taxInclusiveAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', 'TRY');
        $legalMonetaryTotal->addChild('cbc:AllowanceTotalAmount', $allowanceTotalAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', 'TRY');
        $legalMonetaryTotal->addChild('cbc:ChargeTotalAmount', $chargeTotalAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', 'TRY');
        $legalMonetaryTotal->addChild('cbc:PayableAmount', $payableAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', 'TRY');
        return $this->invoice;
    }

    public function taxTotal($baseElement, $taxAmount, $currencyID)
    {
        if ($baseElement == null)
            $taxTotalElement = $this->invoice->addChild('cac:TaxTotal', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        else
            $taxTotalElement = $baseElement->addChild('cac:TaxTotal', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxAmountElement = $taxTotalElement->addChild('cbc:TaxAmount', $taxAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxAmountElement->addAttribute('currencyID', $currencyID);
        return $taxTotalElement;
    }

    public function subTaxTotal($taxTotalElement, $taxableAmount, $taxAmount, $percent, $currencyID, $taxCategory)
    {
        $taxSubtotalElement = $taxTotalElement->addChild('cac:TaxSubtotal', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxableAmountElement = $taxSubtotalElement->addChild('cbc:TaxableAmount', $taxableAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxableAmountElement->addAttribute('currencyID', $currencyID);
        $taxAmountElement = $taxSubtotalElement->addChild('cbc:TaxAmount', $taxAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxAmountElement->addAttribute('currencyID', $currencyID);
        $percent = $taxSubtotalElement->addChild('cbc:Percent', $percent, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $taxCategoryElement = $taxSubtotalElement->addChild('cac:TaxCategory', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        if ($taxCategory['taxExemptionReasonCode'] != null && $taxCategory['taxExemptionReason'] != null) {
            $taxExemptionReasonCodeElement = $taxCategoryElement->addChild('cbc:TaxExemptionReasonCode', $taxCategory['taxExemptionReasonCode'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $taxExemptionReasonElement = $taxCategoryElement->addChild('cbc:TaxExemptionReason', $taxCategory['taxExemptionReason'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        }
        $taxSchemeElement = $taxCategoryElement->addChild('cac:TaxScheme', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxSchemeElement->addChild('cbc:Name', $taxCategory['taxSchemeName'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxSchemeElement->addChild('cbc:TaxTypeCode', $taxCategory['taxSchemeCode'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        return $taxSubtotalElement;
    }

    public function withholdingTaxTotal($invoiceElement, $taxAmount, $currencyID)
    {
        if ($invoiceElement == null)
            $withholdingTaxTotal = $this->invoice->addChild('cac:WithholdingTaxTotal', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        else
            $withholdingTaxTotal = $invoiceElement->addChild('cac:WithholdingTaxTotal', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $taxAmountElement = $withholdingTaxTotal->addChild('cbc:TaxAmount', $taxAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $taxAmountElement->addAttribute('currencyID', $currencyID);
        return $withholdingTaxTotal;
    }


    public function allowanceCharge($invoiceElement, $chargeIndicator, $allowanceChargeReason, $multiplierFactorNumeric, $amount, $currencyID)
    {
        if ($invoiceElement == null)
            $allowanceCharge = $this->invoice->addChild('cac:AllowanceCharge', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        else
            $allowanceCharge = $invoiceElement->addChild('cac:AllowanceCharge', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $allowanceCharge->addChild('cbc:ChargeIndicator', $chargeIndicator, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $allowanceCharge->addChild('cbc:AllowanceChargeReason', $allowanceChargeReason, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $allowanceCharge->addChild('cbc:MultiplierFactorNumeric', $multiplierFactorNumeric, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $allowanceCharge->addChild('cbc:Amount', $amount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', $currencyID);
        return $allowanceCharge;
    }
    public function addInvoiceLine($lineID, $invoicedQuantity, $unitCode, $lineExtensionAmount, $currencyID, $itemName, $priceAmount)
    {
        $invoiceLine = $this->invoice->addChild('cac:InvoiceLine', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $invoiceLine->addChild('cbc:ID', $lineID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $invoiceLine->addChild('cbc:Note', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $invoicedQuantityElement = $invoiceLine->addChild('cbc:InvoicedQuantity', $invoicedQuantity, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $invoicedQuantityElement->addAttribute('unitCode', $unitCode);
        $lineExtensionAmountElement = $invoiceLine->addChild('cbc:LineExtensionAmount', $lineExtensionAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $lineExtensionAmountElement->addAttribute('currencyID', $currencyID);
        $item = $invoiceLine->addChild('cac:Item', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $item->addChild('cbc:Name', $itemName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $commodityClassification = $item->addChild('cac:CommodityClassification', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $commodityClassification->addChild('cbc:ItemClassificationCode', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $price = $invoiceLine->addChild('cac:Price', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $priceAmountElement = $price->addChild('cbc:PriceAmount', $priceAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $priceAmountElement->addAttribute('currencyID', $currencyID);
        return $invoiceLine;
    }

    public function toXML()
    {
        return $this->invoice->asXML();
    }

    public function save($path)
    {
        $this->invoice->asXML($path);
    }

    public function getInvoice()
    {
        return $this->invoice;
    }

}