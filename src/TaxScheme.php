<?php

namespace CrixuAMG\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class TaxScheme
 *
 * @package CrixuAMG\UBL\Invoice
 */
class TaxScheme implements XmlSerializable
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
     *
     * @return TaxScheme
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