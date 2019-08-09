<?php

namespace CrixuAMG\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class PayeeFinancialAccount
 *
 * @package CrixuAMG\UBL\Invoice
 */
class PayeeFinancialAccount extends XmlSerializable
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

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param Writer $writer
     */
    function xmlSerialize(Writer $writer)
    {
        $writer->write([
            Schema::CBC . 'ID' => $this->id,
        ]);
    }
}
