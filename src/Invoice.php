<?php

namespace weha\UBL\Invoice;

use DateTime;
use InvalidArgumentException;
use App\Payment;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
* Class Invoice
*
* @package weha\UBL\Invoice
*/
class Invoice implements XmlSerializable {
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
    * @var \DateTime
    */
    private $issueDate;
    /**
    * @var \DateTime
    */
    private $dueDate;

    /**
    * @var string
    */
    private $invoiceTypeCode;

    /** @var string */
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
    * @var PaymentMeans
    */
    private $paymentMeans;
    /**
    * @var Party
    */
    private $accountingSupplierParty;
    /**
    * @var Party
    */
    private $accountingCustomerParty;
    /**
    * @var Party
    */
    private $buyerCustomerParty;
    /**
    * @var Party
    */
    private $sellerSupplierParty;    /**
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

    /** @var string */
    private $orderReference;

    /** @var string */
    private $note;

    function validate()
    {
        if ($this->id === null) {
            throw new \InvalidArgumentException('Missing invoice id');
        }

        if ($this->id === null) {
            throw new \InvalidArgumentException('Missing invoice id');
        }

        if (!$this->issueDate instanceof \DateTime) {
            throw new \InvalidArgumentException('Invalid invoice issueDate');
        }

        if (!$this->dueDate instanceof \DateTime) {
            throw new \InvalidArgumentException('Invalid invoice dueDate');
        }

        if ($this->invoiceTypeCode === null) {
            throw new \InvalidArgumentException('Missing invoice invoiceTypeCode');
        }

        if ($this->sellerSupplierParty === null) {
            throw new \InvalidArgumentException('Missing invoice SellerSupplierParty');
        }

        if ($this->invoiceLines === null) {
            throw new \InvalidArgumentException('Missing invoice lines');
        }

        if ($this->legalMonetaryTotal === null) {
            throw new \InvalidArgumentException('Missing invoice LegalMonetaryTotal');
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $this->validate();

        $writer->write([
            Schema::CBC . 'UBLVersionID' => $this->UBLVersionID,
            Schema::CBC . 'CustomizationID' => 'OIOUBL-2.01',
            Schema::CBC . 'ID' => $this->id,
            Schema::CBC . 'CopyIndicator' => $this->copyIndicator ? 'true' : 'false',
            Schema::CBC . 'IssueDate' => $this->issueDate->format('Y-m-d'),
            Schema::CBC . 'DueDate' => $this->dueDate->format('Y-m-d'),
            Schema::CBC . 'InvoiceTypeCode' => $this->invoiceTypeCode,
            Schema::CBC . 'Note' => $this->note,
            Schema::CBC . 'TaxPointDate' => $this->issueDate->format('Y-m-d'),
            Schema::CBC . 'DocumentCurrencyCode' => $this->documentCurrencyCode
        ]);

        if ($this->orderReference) {
            $writer->write([
                Schema::CAC . 'OrderReference' => [
                    Schema::CBC . 'ID' => $this->orderReference
                ]
            ]);
        }

        if ($this->accountingSupplierParty != null) {
            $writer->write([
                Schema::CAC . 'AccountingSupplierParty' => [Schema::CAC . "Party" => $this->accountingSupplierParty],
            ]);
        }

        if ($this->accountingCustomerParty != null) {
            $writer->write([
                Schema::CAC . 'AccountingCustomerParty' => [Schema::CAC . "Party" => $this->accountingCustomerParty],
            ]);
        }

        if ($this->buyerCustomerParty != null) {
            $writer->write([
                Schema::CAC . 'BuyerCustomerParty' => [Schema::CAC . "Party" => $this->buyerCustomerParty],
            ]);
        }

        $writer->write([
            Schema::CAC . 'SellerSupplierParty' => [Schema::CAC . "Party" => $this->sellerSupplierParty],
        ]);

        if ($this->additionalDocumentReference != null) {
            $writer->write([
                Schema::CAC . 'AdditionalDocumentReference' => $this->additionalDocumentReference,
            ]);
        }

        if ($this->paymentMeans != null) {
            $writer->write([
                Schema::CAC . 'PaymentMeans' => $this->paymentMeans
            ]);
        }

        if ($this->paymentTerms != null) {
            $writer->write([
                Schema::CAC . 'PaymentTerms' => $this->paymentTerms
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
    * @return \DateTime
    */
    public function getDueDate() {
        return $this->dueDate;
    }

    /**
    * @param \DateTime $dueDate
    * @return Invoice
    */
    public function setDueDate($dueDate) {
        $this->dueDate = $dueDate;
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
    public function setInvoiceTypeCode($invoiceTypeCode) {
        $this->invoiceTypeCode = $invoiceTypeCode;

        return $this;
    }

    /**
    * @return AdditionalDocumentReference
    */
    public function getAdditionalDocumentReference() {
        return $this->additionalDocumentReference;
    }

    /**
    * @param AdditionalDocumentReference $additionalDocumentReference
    *
    * @return Invoice
    */
    public function setAdditionalDocumentReference($additionalDocumentReference) {
        $this->additionalDocumentReference = $additionalDocumentReference;

        return $this;
    }

    /**
    * @return Party
    */
    public function getAccountingSupplierParty() {
        return $this->accountingSupplierParty;
    }

    /**
    * @param Party $accountingSupplierParty
    *
    * @return Invoice
    */
    public function setAccountingSupplierParty($accountingSupplierParty) {
        $this->accountingSupplierParty = $accountingSupplierParty;
        return $this;
    }

    /**
    * @return Party
    */
    public function getSellerSupplierParty() {
        return $this->sellerSupplierParty;
    }

    /**
    * @param Party $sellerSupplierParty
    *
    * @return Invoice
    */
    public function setSellerSupplierParty($sellerSupplierParty) {
        $this->sellerSupplierParty = $sellerSupplierParty;
        return $this;
    }

    /**
    * @return Party
    */
    public function getAccountingCustomerParty() {
        return $this->accountingCustomerParty;
    }

    /**
    * @param Party $accountingCustomerParty
    *
    * @return Invoice
    */
    public function setAccountingCustomerParty($accountingCustomerParty) {
        $this->accountingCustomerParty = $accountingCustomerParty;
        return $this;
    }

    /**
    * @return Party
    */
    public function getBuyerCustomerParty() {
        return $this->buyerCustomerParty;
    }

    /**
    * @param Party $buyerCustomerParty
    *
    * @return Invoice
    */
    public function setBuyerCustomerParty($buyerCustomerParty) {
        $this->buyerCustomerParty = $buyerCustomerParty;
        return $this;
    }

    /**
    * @return PaymentMeans
    */
    public function getPaymentMeans()
    {
        return $this->paymentMeans;
    }

    /**
    * @return TaxTotal
    */
    public function getTaxTotal() {
        return $this->taxTotal;
    }

    /**
    * @param TaxTotal $taxTotal
    *
    * @return Invoice
    */
    public function setTaxTotal($taxTotal) {
        $this->taxTotal = $taxTotal;

        return $this;
    }

    /**
    * @return LegalMonetaryTotal
    */
    public function getLegalMonetaryTotal() {
        return $this->legalMonetaryTotal;
    }

    /**
    * @param LegalMonetaryTotal $legalMonetaryTotal
    *
    * @return Invoice
    */
    public function setLegalMonetaryTotal($legalMonetaryTotal) {
        $this->legalMonetaryTotal = $legalMonetaryTotal;

        return $this;
    }

    /**
    * @return InvoiceLine[]
    */
    public function getInvoiceLines() {
        return $this->invoiceLines;
    }

    /**
    * @param InvoiceLine[] $invoiceLines
    *
    * @return Invoice
    */
    public function setInvoiceLines($invoiceLines) {
        $this->invoiceLines = $invoiceLines;

        return $this;
    }

    /**
    * @return AllowanceCharge[]
    */
    public function getAllowanceCharges() {
        return $this->allowanceCharges;
    }

    /**
    * @param AllowanceCharge[] $allowanceCharges
    *
    * @return Invoice
    */
    public function setAllowanceCharges($allowanceCharges) {
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
    *
    * @return Invoice
    */
    public function setPaymentTerms(PaymentTerms $paymentTerms): Invoice
    {
        $this->paymentTerms = $paymentTerms;

        return $this;
    }

    /**
    * @return string
    */
    public function getDocumentCurrencyCode(): string
    {
        return $this->documentCurrencyCode;
    }

    /**
    * @param string $documentCurrencyCode
    */
    public function setDocumentCurrencyCode(string $documentCurrencyCode)
    {
        $this->documentCurrencyCode = $documentCurrencyCode;
        return $this;
    }

    /**
    * @return mixed
    */
    public function getOrderReference()
    {
        return $this->orderReference;
    }

    /**
    * @param mixed $orderReference
    * @return self
    */
    public function setOrderReference($orderReference): self
    {
        $this->orderReference = $orderReference;
        return $this;
    }

    public function setPaymentMeans($paymentMeans): self
    {
        $this->paymentMeans = $paymentMeans;
        return $this;
    }

    /**
    * @param mixed $note
    */
    public function setNote($note): self
    {
        $this->note = $note;
        return $this;
    }
}
