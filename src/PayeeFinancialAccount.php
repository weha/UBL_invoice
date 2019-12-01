<?php

namespace weha\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class PayeeFinancialAccount
 *
 * @package weha\UBL\Invoice
 */
class PayeeFinancialAccount implements XmlSerializable
{
    /**
     * @var
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name' => Schema::CBC . 'ID',
            'value' => $this->id,
            'attributes' => [
                'schemeID' => 'IBAN'
            ]
        ]);
    }
}
