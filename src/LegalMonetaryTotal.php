<?php

namespace weha\UBL\Invoice;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class LegalMonetaryTotal implements XmlSerializable {
    private $lineExtensionAmount;
    /**
     * @var
     */
    private $taxExclusiveAmount;
    /**
     * @var
     */
    private $taxInclusiveAmount;
    /**
     * @var int
     */
    private $allowanceTotalAmount = 0;
    /**
     * @var
     */
    private $payableAmount;

    public function setLineExtensionAmount($lineExtensionAmount) {
        $this->lineExtensionAmount = $lineExtensionAmount;

        return $this;
    }

    public function setTaxExclusiveAmount($taxExclusiveAmount) {
        $this->taxExclusiveAmount = $taxExclusiveAmount;

        return $this;
    }

    public function setTaxInclusiveAmount($taxInclusiveAmount) {
        $this->taxInclusiveAmount = $taxInclusiveAmount;

        return $this;
    }

    public function setAllowanceTotalAmount($allowanceTotalAmount) {
        $this->allowanceTotalAmount = $allowanceTotalAmount;

        return $this;
    }

    public function setPayableAmount($payableAmount) {
        $this->payableAmount = $payableAmount;

        return $this;
    }

    function xmlSerialize(Writer $writer) {
        $writer->write([
            [
                'name' => Schema::CBC . 'LineExtensionAmount',
                'value' => number_format($this->lineExtensionAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]

            ],
            [
                'name' => Schema::CBC . 'TaxExclusiveAmount',
                'value' => number_format($this->taxExclusiveAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]

            ],
            [
                'name' => Schema::CBC . 'TaxInclusiveAmount',
                'value' => number_format($this->taxInclusiveAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]
            ]
        ]);

        if ($this->allowanceTotalAmount) {
            $writer->write([
                'name' => Schema::CBC . 'AllowanceTotalAmount',
                'value' => number_format($this->allowanceTotalAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]
            ]);
        }

        $writer->write([
                'name' => Schema::CBC . 'PayableAmount',
                'value' => number_format($this->payableAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]
        ]);
    }
}
