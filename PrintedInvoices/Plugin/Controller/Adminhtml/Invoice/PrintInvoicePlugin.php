<?php
/**
 * @package   Igor_PrintedInvoices
 * @version   1.0.0
 * @author    Igor Persona
 */
declare(strict_types=1);

namespace Igor\PrintedInvoices\Plugin\Controller\Adminhtml\Invoice;

use Igor\PrintButton\Controller\Adminhtml\Invoice\PrintInvoice;
use Igor\PrintedInvoices\Model\InvoicePrinter;
use Magento\Framework\Message\ManagerInterface;
use Exception;

/**
 * Class PrintInvoicePlugin
 * @package Igor\PrintedInvoices\Plugin\Controller\Adminhtml\Invoice
 */
class PrintInvoicePlugin {

    /**
     * @var InvoicePrinter
     */
    protected $invoicePrinter;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * PrintInvoicePlugin constructor.
     * @param InvoicePrinter $invoicePrinter
     * @param ManagerInterface $messageManager
     */
    public function __construct(InvoicePrinter $invoicePrinter,ManagerInterface $messageManager)
    {
        $this->invoicePrinter = $invoicePrinter;
        $this->messageManager = $messageManager;
    }

    /**
     * @param PrintInvoice $subject
     * @return array|null
     */
    public function beforeExecute(
        PrintInvoice $subject
    ): ?array {
        $invoiceId = $subject->getRequest()->getParam("invoice_id");
        try {
            $this->invoicePrinter->printInvoice($invoiceId);
            $this->messageManager->addSuccessMessage(sprintf("Invoice %s printed successfully", $invoiceId));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(sprintf("Couldn't print invoice %s", $invoiceId));
            // Could log this message instead with Psr\Log\LoggerInterface
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return null;
    }
}
