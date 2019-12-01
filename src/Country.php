<?php

namespace weha\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Country
 *
 * @package weha\UBL\Invoice
 */
class Country implements XmlSerializable {
    /**
     * @var
     */
    private $identificationCode;

    /**
     * @return mixed
     */
    public function getIdentificationCode() {
        return $this->identificationCode;
    }

    /**
     * @param mixed $identificationCode
     * @return Country
     */
    public function setIdentificationCode($identificationCode) {
        $this->identificationCode = $identificationCode;
        return $this;
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    function xmlSerialize(Writer $writer) {
        $writer->write([
            Schema::CBC.'IdentificationCode' => $this->identificationCode,
        ]);
    }

}
