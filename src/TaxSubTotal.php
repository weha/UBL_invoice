<?php

namespace weha\UBL\Invoice;

use InvalidArgumentException;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class TaxSubTotal
 *
 * @package weha\UBL\Invoice
 */
class TaxSubTotal implements XmlSerializable
{
    /**
     * @var
     */
    private $taxableAmount;
    /**
     * @var
     */
    private $taxAmount;

    /**
     * @var TaxCategory
     */
    private $taxCategory;

    /**
     * @return mixed
     */
    public function getTaxableAmount()
    {
        return $this->taxableAmount;
    }

    /**
     * @param mixed $taxableAmount
     *
     * @return TaxSubTotal
     */
    public function setTaxableAmount($taxableAmount)
    {
        $this->taxableAmount = $taxableAmount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * @param mixed $taxAmount
     *
     * @return TaxSubTotal
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    /**
     * @return TaxCategory
     */
    public function getTaxCategory()
    {
        return $this->taxCategory;
    }

    /**
     * @param TaxCategory $taxCategory
     *
     * @return TaxSubTotal
     */
    public function setTaxCategory($taxCategory)
    {
        $this->taxCategory = $taxCategory;

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
        $this->validate();

        $writer->write([
                [
                    'name'       => Schema::CBC . 'TaxableAmount',
                    'value'      => number_format($this->taxableAmount, 2, '.', ''),
                    'attributes' => [
                        'currencyID' => Generator::$currencyID,
                    ],

                ],
                [
                    'name'       => Schema::CBC . 'TaxAmount',
                    'value'      => number_format($this->taxAmount, 2, '.', ''),
                    'attributes' => [
                        'currencyID' => Generator::$currencyID,
                    ],

                ],
                Schema::CAC . 'TaxCategory' => $this->taxCategory,
            ]
        );
    }

    /**
     *
     */
    public function validate()
    {
        if ($this->taxableAmount === null) {
            throw new InvalidArgumentException('Missing taxsubtotal taxableAmount');
        }

        if ($this->taxAmount === null) {
            throw new InvalidArgumentException('Missing taxsubtotal taxamount');
        }

        if ($this->taxCategory === null) {
            throw new InvalidArgumentException('Missing taxsubtotal taxcategory');
        }
    }
}
