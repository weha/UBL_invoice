<?php

namespace CrixuAMG\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class AdditionalDocumentReference
 *
 * @package CrixuAMG\UBL\Invoice
 */
class AdditionalDocumentReference implements XmlSerializable
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $attachment;
    /**
     * @var
     */
    private $filename;

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
     * @return AdditionalDocumentReference
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param $attachment
     *
     * @return AdditionalDocumentReference
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param $filename
     *
     * @return AdditionalDocumentReference
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @param Writer $writer
     */
    function xmlSerialize(Writer $writer)
    {
        $writer->write([
            Schema::CBC . 'ID'         => $this->id,
            Schema::CAC . 'Attachment' => [
                [
                    'name'       => Schema::CBC . 'EmbeddedDocumentBinaryObject',
                    'value'      => $this->attachment,
                    'attributes' => [
                        'mimeCode' => "application/pdf",
                        'filename' => $this->filename,
                    ],
                ],
            ],
        ]);
    }
}
