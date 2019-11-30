<?php

namespace CrixuAMG\UBL\Invoice\Tests;

use CleverIt\UBL\Invoice\ClassifiedTaxCategory;
use DateInterval;
use Greenter\Ubl\UblValidator;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    private $invoice;

    public function setUp(){
        $xmlService = new \Sabre\Xml\Service();

        $xmlService->namespaceMap = [
            'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2' => '',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac'
        ];

        $invoice = new \CleverIt\UBL\Invoice\Invoice();
        $date = \DateTime::createFromFormat('d-m-Y', '12-12-1994');
        $dueDate = \DateTime::createFromFormat('d-m-Y', '26-12-1994');
        $invoice->setId('CIT1234');
        $invoice->setIssueDate($date);
        $invoice->setDueDate($dueDate);
        $invoice->setInvoiceTypeCode("SalesInvoice");
        $invoice->setOrderReference('12345');
        $invoice->setDocumentCurrencyCode("EUR");

        $accountingSupplierParty = new \CrixuAMG\UBL\Invoice\Party();
        $accountingSupplierParty->setName('CrixuAMG');
        $supplierAddress = (new \CrixuAMG\UBL\Invoice\Address())
            ->setCityName("Eindhoven")
            ->setStreetName("Keizersgracht")
            ->setBuildingNumber("15")
            ->setPostalZone("5600 AC")
            ->setCountry((new \CrixuAMG\UBL\Invoice\Country())->setIdentificationCode("NL"));

        $accountingSupplierParty->setPostalAddress($supplierAddress);
        $accountingSupplierParty->setPhysicalLocation($supplierAddress);
        $accountingSupplierParty->setContact(
            (new \CleverIt\UBL\Invoice\Contact())
                ->setName("John")
                ->setElectronicMail("info@cleverit.nl")
                ->setTelephone("31402939003")
                ->setTelefax("31402939001")
        );

        $invoice->setAccountingSupplierParty($accountingSupplierParty);
        $invoice->setAccountingCustomerParty($accountingSupplierParty);

        $taxtotal = (new \CrixuAMG\UBL\Invoice\TaxTotal())
            ->setTaxAmount(30)
            ->addTaxSubTotal((new \CrixuAMG\UBL\Invoice\TaxSubTotal())
                ->setTaxAmount(21)
                ->setTaxableAmount(100)
                ->setTaxCategory((new \CrixuAMG\UBL\Invoice\TaxCategory())
                    ->setId("H")
                    ->setName("NL, Hoog Tarief")
                    ->setPercent(21.00)
                    ->setTaxScheme((new \CrixuAMG\UBL\Invoice\TaxScheme())
                        ->setId('VAT'))))
            ->addTaxSubTotal((new \CrixuAMG\UBL\Invoice\TaxSubTotal())
                ->setTaxAmount(9)
                ->setTaxableAmount(100)
                ->setTaxCategory((new \CrixuAMG\UBL\Invoice\TaxCategory())
                    ->setId("X")
                    ->setName("NL, Laag Tarief")
                    ->setPercent(9.00)
                    ->setTaxScheme((new \CrixuAMG\UBL\Invoice\TaxScheme())
                        ->setId('VAT'))));


        $item = (new \CleverIt\UBL\Invoice\Item())
            ->setName("Test item")
            ->setDescription("test item description")
            ->setSellersItemIdentification("1ABCD")
            ->setTaxCategory(
                (new TaxCategory())
                    ->setID("S")
                    ->setPercent(21)
            );

        $invoiceLine = (new \CleverIt\UBL\Invoice\InvoiceLine())
            ->setId(1)
            ->setInvoicedQuantity(1)
            ->setLineExtensionAmount(100)
            ->setTaxTotal($taxtotal)
            ->setItem($item);

        $invoice->setInvoiceLines([$invoiceLine]);
        $invoice->setTaxTotal($taxtotal);
        $invoice->setLegalMonetaryTotal((new \CrixuAMG\UBL\Invoice\LegalMonetaryTotal())
            ->setLineExtensionAmount(100)
            ->setTaxExclusiveAmount(100)
            ->setPayableAmount(-1000)
            ->setAllowanceTotalAmount(50));

        $this->invoice = \CrixuAMG\UBL\Invoice\Generator::invoice($invoice, 'EUR');
    }

    public function testInvoiceIsGenerated()
    {

        $this->assertXmlStringEqualsXmlFile(__DIR__ . "/ubl.xml", $this->invoice);
    }

    public function testValidateSchema(){
        $validator = new UblValidator();
        $validator->isValid($this->invoice);
        $this->assertTrue($validator->isValid($this->invoice));
    }
}
