<?php

namespace CrixuAMG\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class Contact
 *
 * @package CrixuAMG\UBL\Invoice
 */
class Contact implements XmlSerializable {
	private $name;
    /**
     * @var
     */
    private $telephone;
    /**
     * @var
     */
    private $telefax;
    /**
     * @var
     */
    private $electronicMail;

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setTelephone($telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function setTelefax($telefax): self
    {
        $this->telefax = $telefax;

        return $this;
    }

    public function setElectronicMail($electronicMail): self
    {
        $this->electronicMail = $electronicMail;

        return $this;
    }

    function xmlSerialize(Writer $writer) {
        $writer->write([
            Schema::CBC.'Name' => $this->name,
            Schema::CBC.'Telephone' => $this->telephone,
            Schema::CBC.'Telefax' => $this->telefax,
            Schema::CBC.'ElectronicMail' => $this->electronicMail,
        ]);
    }
}
