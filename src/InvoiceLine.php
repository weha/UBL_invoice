<?php

namespace CrixuAMG\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class InvoiceLine implements XmlSerializable
{
    private $id;
    private $invoicedQuantity;
    private $lineExtensionAmount;
    private $unitCode = 'MON';
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return InvoiceLine
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoicedQuantity()
    {
        return $this->invoicedQuantity;
    }

    /**
     * @param mixed $invoicedQuantity
     *
     * @return InvoiceLine
     */
    public function setInvoicedQuantity($invoicedQuantity)
    {
        $this->invoicedQuantity = $invoicedQuantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLineExtensionAmount()
    {
        return $this->lineExtensionAmount;
    }

    /**
     * @param mixed $lineExtensionAmount
     *
     * @return InvoiceLine
     */
    public function setLineExtensionAmount($lineExtensionAmount)
    {
        $this->lineExtensionAmount = $lineExtensionAmount;

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
     * @return InvoiceLine
     */
    public function setTaxTotal($taxTotal)
    {
        $this->taxTotal = $taxTotal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     *
     * @return InvoiceLine
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Price $price
     *
     * @return InvoiceLine
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnitCode()
    {
        return $this->unitCode;
    }

    /**
     * @param mixed $unitCode
     *
     * @return InvoiceLine
     */
    public function setUnitCode($unitCode)
    {
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
            Schema::CBC . 'ID'       => $this->id,
            [
                'name'       => Schema::CBC . 'InvoicedQuantity',
                'value'      => $invoicedQuantity,
                'attributes' => array_merge(
                    [
                        'unitCode' => $this->unitCode,
                    ],
                    $invoicedQuantityAttributes
                ),
            ],
            [
                'name'       => Schema::CBC . 'LineExtensionAmount',
                'value'      => number_format($lineExtensionAmount, 2, '.', ''),
                'attributes' => array_merge(
                    [
                        'currencyID' => Generator::$currencyID,
                    ],
                    $lineExtensionAmountAttributes
                ),
            ],
            Schema::CAC . 'TaxTotal' => $this->taxTotal,
            Schema::CAC . 'Item'     => $this->item,
        ]);

        if ($this->price !== null) {
            $writer->write(
                [
                    Schema::CAC . 'Price' => $this->price,
                ]
            );
        }
    }
}
