<?php
namespace Evrenonur;
class EIrsaliye
{

    protected $xml;

    public function __construct()
    {
        $this->xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>' .
            '<DespatchAdvice xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
                xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
                xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
                xmlns:xades="http://uri.etsi.org/01903/v1.3.2#"
                xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2 UBL-DespatchAdvice-2.1.xsd"
                xmlns="urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2"></DespatchAdvice>');
    }

    public function info($profileId,$itemType,$issueDate,$issueTime,$lineCount): void
    {
        $this->xml->addChild('cbc:UBLVersionID', '2.1', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:CustomizationID', 'TR1.2', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:ProfileID', $profileId, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:ID', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:CopyIndicator', 'false', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:UUID', '', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:IssueDate', $issueDate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:IssueTime', $issueTime, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:DespatchAdviceTypeCode', $itemType, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $this->xml->addChild('cbc:LineCountNumeric', $lineCount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
    }
    public function additionalDocumentReference($value): void
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
    public function despatchSupplierParty($webSite,$vkn,$ticaretSicilNo ,$mersisNo,$name,$adres,$ilce,$il,$postakodu = null,$ulke= null,$vergiDairesi= null,$telefon= null,$fax= null,$mail= null): void
    {
        $accountingSupplierParty = $this->xml->addChild('cac:DespatchSupplierParty', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        // Party öğesi
        $party = $accountingSupplierParty->addChild('cac:Party', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        $party->addChild('cbc:WebsiteURI', $webSite, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PartyIdentification öğeleri
        $partyIdentification1 = $party->addChild('cac:PartyIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification1->addChild('cbc:ID', $vkn, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', strlen($vkn) == 11 ? 'TCKN' : 'VKN');

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
    public function deliveryCustomerParty($webSite,$vkn,$name,$adres,$ilce,$il,$postakodu = null,$ulke= null,$vergiDairesi= null,$telefon= null,$fax= null,$mail= null)
    {
        $accountingCustomerParty = $this->xml->addChild('cac:DeliveryCustomerParty', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        // Party öğesi
        $party = $accountingCustomerParty->addChild('cac:Party', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        $party->addChild('cbc:WebsiteURI', $webSite, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PartyIdentification öğesi
        $partyIdentification = $party->addChild('cac:PartyIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification->addChild('cbc:ID', $vkn, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', strlen($vkn) == 11 ? 'TCKN' : 'VKN');

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


    public function createShipment($shipmentID, $valueAmount, $licensePlateID, $driverFirstName, $driverFamilyName, $driverNationalityID, $carrierVKN, $carrierName, $citySubdivisionName, $cityName, $countryName, $despatchDate, $despatchTime, $transportEquipmentIDs = null)
    {
        $shipment = $this->xml->addChild('cac:Shipment', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $shipment->addChild('cbc:ID', $shipmentID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // GoodsItem
        $goodsItem = $shipment->addChild('cac:GoodsItem', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $goodsItem->addChild('cbc:ValueAmount', $valueAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', 'TRY');

        // ShipmentStage
        $shipmentStage = $shipment->addChild('cac:ShipmentStage', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        // TransportMeans
        $transportMeans = $shipmentStage->addChild('cac:TransportMeans', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $roadTransport = $transportMeans->addChild('cac:RoadTransport', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $roadTransport->addChild('cbc:LicensePlateID', $licensePlateID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'PLAKA');

        // DriverPerson
        $driverPerson = $shipmentStage->addChild('cac:DriverPerson', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $driverPerson->addChild('cbc:FirstName', $driverFirstName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $driverPerson->addChild('cbc:FamilyName', $driverFamilyName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $driverPerson->addChild('cbc:NationalityID', $driverNationalityID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Delivery
        $delivery = $shipment->addChild('cac:Delivery', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        // CarrierParty
        $carrierParty = $delivery->addChild('cac:CarrierParty', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification = $carrierParty->addChild('cac:PartyIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyIdentification->addChild('cbc:ID', $carrierVKN, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', strlen($carrierVKN) == 11 ? 'TCKN' : 'VKN');
        $partyName = $carrierParty->addChild('cac:PartyName', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $partyName->addChild('cbc:Name', $carrierName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // PostalAddress
        $postalAddress = $carrierParty->addChild('cac:PostalAddress', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $postalAddress->addChild('cbc:CitySubdivisionName', $citySubdivisionName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $postalAddress->addChild('cbc:CityName', $cityName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $country = $postalAddress->addChild('cac:Country', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $country->addChild('cbc:Name', $countryName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Despatch
        $despatch = $delivery->addChild('cac:Despatch', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $despatch->addChild('cbc:ActualDespatchDate', $despatchDate, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $despatch->addChild('cbc:ActualDespatchTime', $despatchTime, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        if ($transportEquipmentIDs != null){
            $transportHandlingUnit = $shipment->addChild('cac:TransportHandlingUnit', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            foreach ($transportEquipmentIDs as $equipmentID) {
                $transportEquipment = $transportHandlingUnit->addChild('cac:TransportEquipment', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
                $transportEquipment->addChild('cbc:ID', $equipmentID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', 'DORSEPLAKA');
            }
        }
    }

    public function addDespatchLine(
        $lineID,
        $note,
        $deliveredQuantity,
        $deliveredQuantityUnitCode,
        $outstandingQuantity,
        $outstandingQuantityUnitCode,
        $oversupplyQuantity,
        $oversupplyQuantityUnitCode,
        $orderLineReferenceLineID,
        $shipmentID, $invoiceLineID, $invoicedQuantity, $lineExtensionAmount, $itemWithinInvoiceLineName, $priceAmount,
        $itemName = null,
        $itemDescription = null,
        $brandName = null,
        $buyersItemIdentification = null,
        $sellersItemIdentification = null,
        $additionalItemIdentification = null,
        )
    {
        $despatchLine = $this->xml->addChild('cac:DespatchLine', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        $despatchLine->addChild('cbc:ID', $lineID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $despatchLine->addChild('cbc:Note', $note, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $deliveredQuantityElement = $despatchLine->addChild('cbc:DeliveredQuantity', $deliveredQuantity, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $deliveredQuantityElement->addAttribute('unitCode', $deliveredQuantityUnitCode);

        $outstandingQuantityElement = $despatchLine->addChild('cbc:OutstandingQuantity', $outstandingQuantity, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $outstandingQuantityElement->addAttribute('unitCode', $outstandingQuantityUnitCode);

        $oversupplyQuantityElement = $despatchLine->addChild('cbc:OversupplyQuantity', $oversupplyQuantity, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $oversupplyQuantityElement->addAttribute('unitCode', $oversupplyQuantityUnitCode);

        $orderLineReference = $despatchLine->addChild('cac:OrderLineReference', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $orderLineReference->addChild('cbc:LineID', $orderLineReferenceLineID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');


        if ($itemName != null && $itemDescription != null && $brandName != null && $buyersItemIdentification != null && $sellersItemIdentification != null){
            $item = $despatchLine->addChild('cac:Item', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $item->addChild('cbc:Description', $itemDescription, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $item->addChild('cbc:Name', $itemName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $item->addChild('cbc:BrandName', $brandName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

            // BuyersItemIdentification
            $buyersItemIdentificationLine = $item->addChild('cac:BuyersItemIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $buyersItemIdentificationLine->addChild('cbc:ID', $buyersItemIdentification, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

            // SellersItemIdentification
            $sellersItemIdentificationLine = $item->addChild('cac:SellersItemIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $sellersItemIdentificationLine->addChild('cbc:ID', $sellersItemIdentification, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

            if ($additionalItemIdentification != null){
                foreach ($additionalItemIdentification as $itemIdentification) {
                    $additionalItemIdentificationLine = $item->addChild('cac:AdditionalItemIdentification', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
                    $additionalItemIdentificationLine->addChild('cbc:ID', $itemIdentification['id'], 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('schemeID', $itemIdentification['value']);
                }
            }

        }else{
            $item = $despatchLine->addChild('cac:Item', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $item->addChild('cbc:Name', $itemName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        }


        $shipment = $despatchLine->addChild('cac:Shipment', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $shipment->addChild('cbc:ID', $shipmentID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $goodsItem = $shipment->addChild('cac:GoodsItem', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        $invoiceLine = $goodsItem->addChild('cac:InvoiceLine', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $invoiceLine->addChild('cbc:ID', $invoiceLineID, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $invoiceLine->addChild('cbc:InvoicedQuantity', $invoicedQuantity, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $lineExtensionAmount = $invoiceLine->addChild('cbc:LineExtensionAmount', $lineExtensionAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $lineExtensionAmount->addAttribute('currencyID', 'TRY');

        $itemWithinInvoiceLine = $invoiceLine->addChild('cac:Item', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $itemWithinInvoiceLine->addChild('cbc:Name', $itemWithinInvoiceLineName, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $price = $invoiceLine->addChild('cac:Price', null, 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $price->addChild('cbc:PriceAmount', $priceAmount, 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2')->addAttribute('currencyID', 'TRY');
    }

    public function toXml(): string
    {
        return $this->xml->asXML();
    }

}