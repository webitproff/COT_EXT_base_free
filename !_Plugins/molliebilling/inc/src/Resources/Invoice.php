<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Types\InvoiceStatus;
class Invoice extends \Mollie\Api\Resources\BaseResource
{
    /**
     * @var string
     */
    public $resource;
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $reference;
    /**
     * @var string
     */
    public $vatNumber;
    /**
     * @var string
     */
    public $status;
    /**
     * Date the invoice was issued, e.g. 2018-01-01
     *
     * @var string
     */
    public $issuedAt;
    /**
     * Date the invoice was paid, e.g. 2018-01-01
     *
     * @var string|null
     */
    public $paidAt;
    /**
     * Date the invoice is due, e.g. 2018-01-01
     *
     * @var string|null
     */
    public $dueAt;
    /**
     * Amount object containing the total amount of the invoice excluding VAT.
     *
     * @var \stdClass
     */
    public $netAmount;
    /**
     * Amount object containing the VAT amount of the invoice. Only for merchants registered in the Netherlands.
     *
     * @var \stdClass
     */
    public $vatAmount;
    /**
     * Total amount of the invoice including VAT.
     *
     * @var \stdClass
     */
    public $grossAmount;
    /**
     * Object containing the invoice lines.
     * See https://docs.mollie.com/reference/v2/invoices-api/get-invoice for reference
     *
     * @var \stdClass
     */
    public $lines;
    /**
     * Contains a PDF to the Invoice
     *
     * @var \stdClass
     */
    public $_links;
    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->status == \Mollie\Api\Types\InvoiceStatus::STATUS_PAID;
    }
    /**
     * @return bool
     */
    public function isOpen()
    {
        return $this->status == \Mollie\Api\Types\InvoiceStatus::STATUS_OPEN;
    }
    /**
     * @return bool
     */
    public function isOverdue()
    {
        return $this->status == \Mollie\Api\Types\InvoiceStatus::STATUS_OVERDUE;
    }
}
