<?php

namespace CrixuAMG\UBL\Invoice;

use DateTime;
use InvalidArgumentException;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Invoice
 *
 * @package CrixuAMG\UBL\Invoice
 */
class Invoice implements XmlSerializable
{
    /**
     * @var string
     */
    private $UBLVersionID = '2.1';

    /**
     * @var int
     */
    private $id;
    /**
     * @var bool
     */
    private $copyIndicator = false;

    /**
     * @var DateTime
     */
    private $issueDate;
    /**
     * @var string
     */
    private $invoiceTypeCode;
    /**
     * @var string
     */
    private $documentCurrencyCode;
    /**
     * @var AdditionalDocumentReference
     */
    private $additionalDocumentReference;
    /**
     * @var PaymentTerms
     */
    private $paymentTerms;
    /**
     * @var Party
     */
    private $accountingSupplierParty;
    /**
     * @var Party
     */
    private $accountingCustomerParty;
    /**
     * @var TaxTotal
     */
    private $taxTotal;
    /**
     * @var LegalMonetaryTotal
     */
    private $legalMonetaryTotal;
    /**
     * @var InvoiceLine[]
     */
    private $invoiceLines;
    /**
     * @var AllowanceCharge[]
     */
    private $allowanceCharges;

    /**
     * @param Writer $writer
     */
    function xmlSerialize(Writer $writer)
    {
        $this->validate();

        $writer->write([
            Schema::CBC . 'UBLVersionID'            => $this->UBLVersionID,
            Schema::CBC . 'CustomizationID'         => 'OIOUBL-2.01',
            Schema::CBC . 'ID'                      => $this->id,
            Schema::CBC . 'CopyIndicator'           => $this->copyIndicator ? 'true' : 'false',
            Schema::CBC . 'IssueDate'               => $this->issueDate->format('Y-m-d'),
            Schema::CBC . 'InvoiceTypeCode'         => $this->invoiceTypeCode,
            Schema::CBC . 'DocumentCurrencyCode'    => $this->documentCurrencyCode,
            Schema::CAC . 'AccountingSupplierParty' => [Schema::CAC . "Party" => $this->accountingSupplierParty],
            Schema::CAC . 'AccountingCustomerParty' => [Schema::CAC . "Party" => $this->accountingCustomerParty],
        ]);

        if ($this->additionalDocumentReference != null) {
            $writer->write([
                Schema::CAC . 'AdditionalDocumentReference' => $this->additionalDocumentReference,
            ]);
        }

        if ($this->allowanceCharges != null) {
            foreach ($this->allowanceCharges as $invoiceLine) {
                $writer->write([
                    Schema::CAC . 'AllowanceCharge' => $invoiceLine,
                ]);
            }
        }

        if ($this->taxTotal != null) {
            $writer->write([
                Schema::CAC . 'TaxTotal' => $this->taxTotal,
            ]);
        }

        $writer->write([
            Schema::CAC . 'LegalMonetaryTotal' => $this->legalMonetaryTotal,
        ]);

        foreach ($this->invoiceLines as $invoiceLine) {
            $writer->write([
                Schema::CAC . 'InvoiceLine' => $invoiceLine,
            ]);
        }

        if (!empty($this->paymentTerms)) {
            $writer->write([
                Schema::CAC . 'PaymentTerms' => $this->paymentTerms,
            ]);
        }
    }

    /**
     *
     */
    function validate()
    {
        if ($this->id === null) {
            throw new InvalidArgumentException('Missing invoice id');
        }

        if ($this->id === null) {
            throw new InvalidArgumentException('Missing invoice id');
        }

        if (!$this->issueDate instanceof DateTime) {
            throw new InvalidArgumentException('Invalid invoice issueDate');
        }

        if ($this->invoiceTypeCode === null) {
            throw new InvalidArgumentException('Missing invoice invoiceTypeCode');
        }

        if ($this->documentCurrencyCode === null) {
            throw new InvalidArgumentException('Missing invoice cbc:documentCurrencyCode');
        }

        if ($this->accountingSupplierParty === null) {
            throw new InvalidArgumentException('Missing invoice accountingSupplierParty');
        }

        if ($this->accountingCustomerParty === null) {
            throw new InvalidArgumentException('Missing invoice accountingCustomerParty');
        }

        if ($this->invoiceLines === null) {
            throw new InvalidArgumentException('Missing invoice lines');
        }

        if ($this->legalMonetaryTotal === null) {
            throw new InvalidArgumentException('Missing invoice LegalMonetaryTotal');
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Invoice
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCopyIndicator()
    {
        return $this->copyIndicator;
    }

    /**
     * @param boolean $copyIndicator
     *
     * @return Invoice
     */
    public function setCopyIndicator($copyIndicator)
    {
        $this->copyIndicator = $copyIndicator;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * @param DateTime $issueDate
     *
     * @return Invoice
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceTypeCode()
    {
        return $this->invoiceTypeCode;
    }

    /**
     * @param string $invoiceTypeCode
     *
     * @return Invoice
     */
    public function setInvoiceTypeCode($invoiceTypeCode)
    {
        $this->invoiceTypeCode = $invoiceTypeCode;

        return $this;
    }

    /**
     * @return string|array|null
     */
    public function getDocumentCurrencyCode()
    {
        return $this->documentCurrencyCode;
    }

    /**
     * @param string $documentCurrencyCode
     *
     * @return Invoice
     */
    public function setDocumentCurrencyCode($documentCurrencyCode)
    {
        $this->documentCurrencyCode = $documentCurrencyCode;

        return $this;
    }

    /**
     * @return AdditionalDocumentReference
     */
    public function getAdditionalDocumentReference()
    {
        return $this->additionalDocumentReference;
    }

    /**
     * @param AdditionalDocumentReference $additionalDocumentReference
     *
     * @return Invoice
     */
    public function setAdditionalDocumentReference($additionalDocumentReference)
    {
        $this->additionalDocumentReference = $additionalDocumentReference;

        return $this;
    }

    /**
     * @return Party
     */
    public function getAccountingSupplierParty()
    {
        return $this->accountingSupplierParty;
    }

    /**
     * @param Party $accountingSupplierParty
     *
     * @return Invoice
     */
    public function setAccountingSupplierParty($accountingSupplierParty)
    {
        $this->accountingSupplierParty = $accountingSupplierParty;

        return $this;
    }

    /**
     * @return Party
     */
    public function getAccountingCustomerParty()
    {
        return $this->accountingCustomerParty;
    }

    /**
     * @param Party $accountingCustomerParty
     *
     * @return Invoice
     */
    public function setAccountingCustomerParty($accountingCustomerParty)
    {
        $this->accountingCustomerParty = $accountingCustomerParty;

        return $this;
    }

    /**
     * @return TaxTotal
     */
    public function getTaxTotal()
    {
        return $this->taxTotal;
    }

    /**
     * @param TaxTotal $taxTotal
     *
     * @return Invoice
     */
    public function setTaxTotal($taxTotal)
    {
        $this->taxTotal = $taxTotal;

        return $this;
    }

    /**
     * @return LegalMonetaryTotal
     */
    public function getLegalMonetaryTotal()
    {
        return $this->legalMonetaryTotal;
    }

    /**
     * @param LegalMonetaryTotal $legalMonetaryTotal
     *
     * @return Invoice
     */
    public function setLegalMonetaryTotal($legalMonetaryTotal)
    {
        $this->legalMonetaryTotal = $legalMonetaryTotal;

        return $this;
    }

    /**
     * @return InvoiceLine[]
     */
    public function getInvoiceLines()
    {
        return $this->invoiceLines;
    }

    /**
     * @param InvoiceLine[] $invoiceLines
     *
     * @return Invoice
     */
    public function setInvoiceLines($invoiceLines)
    {
        $this->invoiceLines = $invoiceLines;

        return $this;
    }

    /**
     * @return AllowanceCharge[]
     */
    public function getAllowanceCharges()
    {
        return $this->allowanceCharges;
    }

    /**
     * @param AllowanceCharge[] $allowanceCharges
     *
     * @return Invoice
     */
    public function setAllowanceCharges($allowanceCharges)
    {
        $this->allowanceCharges = $allowanceCharges;

        return $this;
    }

    /**
     * @return PaymentTerms
     */
    public function getPaymentTerms(): PaymentTerms
    {
        return $this->paymentTerms;
    }

    /**
     * @param PaymentTerms $paymentTerms
     */
    public function setPaymentTerms(PaymentTerms $paymentTerms): void
    {
        $this->paymentTerms = $paymentTerms;
    }
}
