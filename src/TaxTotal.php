<?php

namespace weha\UBL\Invoice;

use InvalidArgumentException;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class TaxTotal
 *
 * @package weha\UBL\Invoice
 */
class TaxTotal implements XmlSerializable
{
    /**
     * @var
     */
    private $taxAmount;
    /**
     * @var array
     */
    private $taxSubTotals = array();

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
     * @return TaxTotal
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    /**
     * @return array
     */
    public function getTaxSubTotals()
    {
        return $this->taxSubTotals;
    }

    /**
     * @param TaxSubTotal $taxSubTotal
     *
     * @return TaxTotal
     */
    public function addTaxSubTotal($taxSubTotal)
    {
        $this->taxSubTotals[] = $taxSubTotal;

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
                'name'       => Schema::CBC . 'TaxAmount',
                'value'      => number_format($this->taxAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID,
                ],
            ],
        ]);

        foreach ($this->taxSubTotals as $taxSubTotal) {
            $writer->write([Schema::CAC . 'TaxSubtotal' => $taxSubTotal]);
        }
    }

    /**
     *
     */
    public function validate()
    {
        if ($this->taxAmount === null) {
            throw new InvalidArgumentException('Missing taxtotal taxamount');
        }
    }
}
