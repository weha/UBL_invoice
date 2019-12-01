<?php
/**
 * Class Item
 *
 * @package weha\UBL\Invoice
 */

namespace weha\UBL\Invoice;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Item implements XmlSerializable {
    private $description;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $sellersItemIdentification;
    /**
     * @var
     */
    private $taxCategory;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxCategory()
    {
        return $this->taxCategory;
    }

    /**
     * @param mixed $taxCategory
     *
     * @return Item
     */
    public function setTaxCategory($taxCategory)
    {
        $this->taxCategory = $taxCategory;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSellersItemIdentification()
    {
        return $this->sellersItemIdentification;
    }

    /**
     * @param mixed $sellersItemIdentification
     *
     * @return Item
     */
    public function setSellersItemIdentification($sellersItemIdentification)
    {
        $this->sellersItemIdentification = $sellersItemIdentification;

        return $this;
    }


    public function setClassifiedTaxCategory($classifiedTaxCategory)
    {
        $this->classifiedTaxCategory = $classifiedTaxCategory;
        return $this;
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     *
     * @return void
     */
    function xmlSerialize(Writer $writer)
    {
        $writer->write([
            Schema::CBC . 'Description'               => $this->description,
            Schema::CBC . 'Name'                      => $this->name,
            Schema::CAC . 'SellersItemIdentification' => [
                Schema::CBC . 'ID' => $this->sellersItemIdentification,
            ],
        ]);

        if ($this->taxCategory) {
            $writer->write([
                Schema::CAC . 'ClassifiedTaxCategory' => $this->taxCategory,
            ]);
        }
    }
}