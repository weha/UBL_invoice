<?php

namespace CleverIt\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use DateTime;

class PaymentMeans implements XmlSerializable {
	private $paymentMeansCode = 1;
    private $payeeFinancialAccount;
	private $paymentDueDate;


    /**
     * @return mixed
     */
    public function getPaymentMeansCode()
    {
        return $this->paymentMeansCode;
    }

    /**
     * @param mixed $paymentMeansCode
     * @return PaymentMeans
     */
    public function setPaymentMeansCode($paymentMeansCode)
    {
        $this->paymentMeansCode = $paymentMeansCode;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPaymentDueDate()
    {
        return $this->paymentDueDate;
    }

    /**
     * @param \DateTime $paymentDueDate
     * @return PaymentMeans
     */
    public function setPaymentDueDate(\DateTime $paymentDueDate)
    {
        $this->paymentDueDate = $paymentDueDate;
        return $this;
    }

    public function getPayeeFinancialAccount() {
        return $this->payeeFinancialAccount;
    }

    public function setPayeeFinancialAccount($payeeFinancialAccount) {
        $this->payeeFinancialAccount = $payeeFinancialAccount;
        return $this;
    }

    const SEPA_TRANSFER = 58;
    const SEPA_DIRECT_DEBIT = 59;

    function xmlSerialize(Writer $writer) {
        $writer->write([
            [
                'name' => Schema::CBC.'PaymentMeansCode',
                'value' => $this->paymentMeansCode,
            ],
            Schema::CAC.'PayeeFinancialAccount' => [[
                'name' => Schema::CBC . 'ID',
                'value' => $this->payeeFinancialAccount,
                'attributes' => [
                    'schemeID' => 'IBAN'
                ]
            ]]
        ]);
    }

    public function setPayeeFinancialAccount($payeeFinancialAccount)
    {
        $this->payeeFinancialAccount = $payeeFinancialAccount;
        return $this;
    }
}
