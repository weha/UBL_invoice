<?php

namespace CrixuAMG\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PaymentTerms implements XmlSerializable
{
    /**
     * @var string
     */
    private $note;

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @param Writer $writer
     */
    function xmlSerialize(Writer $writer)
    {
        $writer->write([
            Schema::CBC . 'Note' => $this->note,
        ]);
    }
}
