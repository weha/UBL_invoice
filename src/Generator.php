<?php

namespace CrixuAMG\UBL\Invoice;

use Sabre\Xml\Service;

/**
 * Class Generator
 *
 * @package CrixuAMG\UBL\Invoice
 */
class Generator
{
    /**
     * @var
     */
    public static $currencyID;

    /**
     * @param Invoice $invoice
     * @param string  $currencyId
     *
     * @return string
     */
    public static function invoice(Invoice $invoice, $currencyId = 'EUR')
    {
        self::$currencyID = $currencyId;

        $xmlService = new Service();

        $xmlService->namespaceMap = [
            'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'                   => '',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2'     => 'cbc',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac',
        ];

        return $xmlService->write('Invoice', [
            $invoice,
        ]);
    }
}
