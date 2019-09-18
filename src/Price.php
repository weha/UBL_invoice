<?php

namespace CrixuAMG\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Price
 *
 * @package CrixuAMG\UBL\Invoice
 */
class Price implements XmlSerializable
{
    /**
     * @var
     */
    private $priceAmount;
    /**
     * @var
     */
    private $baseQuantity;
    /**
     * @var string
     */
    private $unitCode = 'MON';

    /**
     * @return mixed
     */
    public function getPriceAmount()
    {
        return $this->priceAmount;
    }

    /**
     * @param mixed $priceAmount
     *
     * @return Price
     */
    public function setPriceAmount($priceAmount)
    {
        $this->priceAmount = $priceAmount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaseQuantity()
    {
        return $this->baseQuantity;
    }

    /**
     * @param mixed $baseQuantity
     *
     * @return Price
     */
    public function setBaseQuantity($baseQuantity)
    {
        $this->baseQuantity = $baseQuantity;

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
     * @return Price
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
        $writer->write([
            [
                'name'       => Schema::CBC . 'PriceAmount',
                'value'      => $this->priceAmount,
                'attributes' => [
                    'currencyID' => Generator::$currencyID,
                ],
            ],
            [
                'name'       => Schema::CBC . 'BaseQuantity',
                'value'      => $this->baseQuantity,
                'attributes' => [
                    'unitCode' => $this->unitCode,
                ],
            ],
        ]);
    }
}
