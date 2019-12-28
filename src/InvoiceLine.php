<?php
/**
 * Class InvoiceLine
 *
 * @package weha\UBL\Invoice
 */

namespace weha\UBL\Invoice;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class InvoiceLine implements XmlSerializable {
    private $id;
    /**
     * @var
     */
    private $invoicedQuantity;
    /**
     * @var
     */
    private $lineExtensionAmount;
    private $documentReference;
    private $unitCode = 'MON';
    private $note;

    /**
     * @var TaxTotal
     */
    private $taxTotal;
    /**
     * @var Item
     */
    private $item;
    /**
     * @var Price
     */
    private $price;

    /**
     * @param mixed $id
     *
     * @return InvoiceLine
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $invoicedQuantity
     *
     * @return InvoiceLine
     */
    public function setInvoicedQuantity($invoicedQuantity) {
        $this->invoicedQuantity = $invoicedQuantity;

        return $this;
    }

    /**
     * @param mixed $lineExtensionAmount
     *
     * @return InvoiceLine
     */
    public function setLineExtensionAmount($lineExtensionAmount) {
        $this->lineExtensionAmount = $lineExtensionAmount;

        return $this;
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
     * @return InvoiceLine
     */
    public function setTaxTotal($taxTotal) {
        $this->taxTotal = $taxTotal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * @param mixed $item
     *
     * @return InvoiceLine
     */
    public function setItem($item) {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @param Price $price
     *
     * @return InvoiceLine
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnitCode() {
        return $this->unitCode;
    }

    /**
     * @param mixed $unitCode
     *
     * @return InvoiceLine
     */
    public function setUnitCode($unitCode) {
        $this->unitCode = $unitCode;

        return $this;
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     *
     * @return void
     */
    function xmlSerialize(Writer $writer)
    {
        $lineExtensionAmount           = $this->lineExtensionAmount;
        $lineExtensionAmountAttributes = [];
        if (is_array($lineExtensionAmount)) {
            if (!empty($lineExtensionAmount['attributes'])) {
                $lineExtensionAmountAttributes = $lineExtensionAmount['attributes'];
            }
            if (!empty($lineExtensionAmount['value'])) {
                $lineExtensionAmount = $lineExtensionAmount['value'];
            }
        }

        $invoicedQuantity           = $this->invoicedQuantity;
        $invoicedQuantityAttributes = [];
        if (is_array($invoicedQuantity)) {
            if (!empty($invoicedQuantity['attributes'])) {
                $invoicedQuantityAttributes = $invoicedQuantity['attributes'];
            }
            if (!empty($invoicedQuantity['value'])) {
                $invoicedQuantity = $invoicedQuantity['value'];
            }
        }

        $writer->write([
            Schema::CBC . 'ID' => $this->id,
            Schema::CBC.'Note' => $this->note]);

        if ($this->invoicedQuantity!==null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'InvoicedQuantity',
                    'value' => $this->invoicedQuantity,
                    'attributes' => [
                        'unitCode' => $this->unitCode
                    ]
                ]
            ]);
        }

        $writer->write([
            [
                'name' => Schema::CBC . 'LineExtensionAmount',
                'value' => number_format($this->lineExtensionAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]
            ]
        ]);

        if ($this->documentReference) {
            $writer->write([
                Schema::CAC . 'DocumentReference' => [
                    Schema::CBC . 'ID' => $this->documentReference
                ],
            ]);
        }

        $writer->write([
            Schema::CAC . 'TaxTotal' => $this->taxTotal
        ]);

        $writer->write([
            Schema::CAC . 'Item' => $this->item,
        ]);


        if ($this->price !== null) {
            $writer->write(
                [
                    Schema::CAC . 'Price' => $this->price
                ]
            );
        }
    }

    public function setDocumentReference($documentReference): self
    {
        $this->documentReference = $documentReference;

        return $this;
    }

    public function setNote($note): self
    {
        $this->note = $note;
        return $this;
    }
}
