<?php namespace CleverIt\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PaymentMeans implements XmlSerializable {
    private $code;
    private $payeeFinancialAccount;

    const SEPA_TRANSFER = 58;
    const SEPA_DIRECT_DEBIT = 59;

    function xmlSerialize(Writer $writer) {
        $writer->write([
            [
                'name' => Schema::CBC.'PaymentMeansCode',
                'value' => $this->code,
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

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setPayeeFinancialAccount($payeeFinancialAccount)
    {
        $this->payeeFinancialAccount = $payeeFinancialAccount;
        return $this;
    }
}
