<?php
/**
 * @package   Igor_PrintedInvoices
 * @version   1.0.0
 * @author    Igor Persona
 */
declare(strict_types=1);

namespace Igor\PrintedInvoices\Model;

use Magento\Sales\Api\InvoiceRepositoryInterface;
use Exception;

/**
 * Class InvoicePrinter
 * @package Igor\PrintedInvoices\Model
 */
class InvoicePrinter {

    /**
     * @var InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * InvoicePrinter constructor.
     * @param InvoiceRepositoryInterface $invoiceRepository
     */
    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * @param $invoiceId
     * @throws Exception
     */
    public function printInvoice($invoiceId) : void
    {
        $invoice = $this->invoiceRepository->get($invoiceId);
        $invoice->setIsPrinted(1);
        $invoice->save();
    }
}
