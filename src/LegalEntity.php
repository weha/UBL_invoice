<?php

namespace weha\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class LegalEntity
 *
 * @package weha\UBL\Invoice
 */
class LegalEntity implements XmlSerializable
{

    /**
     * @var string
     */
    private $registrationName;

    /**
     * @var int
     */
    private $companyId;

    /**
     * @return string
     */
    public function getRegistrationName()
    {
        return $this->registrationName;
    }

    /**
     * @param $registrationName
     */
    public function setRegistrationName($registrationName)
    {
        $this->registrationName = $registrationName;

        return $this;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * @param Writer $writer
     */
    function xmlSerialize(Writer $writer)
    {
        $writer->write([
            Schema::CBC . 'RegistrationName' => $this->registrationName,
            Schema::CBC . 'CompanyID'        => $this->companyId,
        ]);
    }
}