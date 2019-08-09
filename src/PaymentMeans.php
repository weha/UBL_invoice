<?php

namespace CrixuAMG\UBL\Invoice;

use DateTime;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PaymentMeans implements XmlSerializable
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var DateTime
     */
    private $dueDate;
    /**
     * @var PayeeFinancialAccount
     */
    private $payeeFinancialAccount;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $code
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param DateTime $dueDate
     *
     * @return PaymentMeans
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return PayeeFinancialAccount
     */
    public function getPayeeFinancialAccount()
    {
        return $this->payeeFinancialAccount;
    }

    /**
     * @param PayeeFinancialAccount $payeeFinancialAccount
     *
     * @return PaymentMeans
     */
    public function setPayeeFinancialAccount($payeeFinancialAccount)
    {
        $this->payeeFinancialAccount = $payeeFinancialAccount;

        return $this;
    }

    /**
     * @param Writer $writer
     */
    function xmlSerialize(Writer $writer)
    {
        $writer->write([
            Schema::CBC . 'PaymmentMeansCode' => $this->code,
        ]);

        if (!empty($this->dueDate)) {
            $writer->write([
                Schema::CBC . 'PaymmentMeansDueDate' => $this->dueDate->format('Y-m-d'),
            ]);
        }

        if (!empty($this->payeeFinancialAccount)) {
            $writer->write([
                Schema::CAC . 'PayeeFinancialAccount' => $this->payeeFinancialAccount,
            ]);
        }
    }
}
