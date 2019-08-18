<?php

namespace Smile\Customer\Controller\Adminhtml\PriceRequest;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Smile\Customer\Api\PriceRequestRepositoryInterface;
use Smile\Customer\Model\PriceRequestFactory;
use Smile\Customer\Model\PriceRequest;
use Smile\Customer\Helper;
use Magento\Framework\DataObject;

/**
 * Class Save
 *
 * @package Smile\Customer\Controller\Adminhtml\PriceRequest
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Customer::price_request_save';

    /**
     * Data persistor interface
     *
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * Price request repository interface
     *
     * @var PriceRequestRepositoryInterface
     */
    private $priceRequestRepository;

    /**
     * Price request factory
     *
     * @var PriceRequestFactory
     */
    private $priceRequestFactory;

    /**
     * Email helper
     *
     * @var Helper\Email
     */
    private $email;

    /**
     * Save constructor.
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param PriceRequestRepositoryInterface $priceRequestRepository
     * @param PriceRequestFactory $priceRequestFactory
     * @param Helper\Email $email
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        PriceRequestRepositoryInterface $priceRequestRepository,
        PriceRequestFactory $priceRequestFactory,
        Helper\Email $email
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->priceRequestRepository = $priceRequestRepository;
        $this->priceRequestFactory = $priceRequestFactory;
        $this->email = $email;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');

        $data = $this->getRequest()->getParams();

        if ($data) {
            try {
                $answer = "The price request has been saved.";

                if (!empty($data['answer'])) {
                    $this->email->sendEmail($data);
                    $answer = $answer . " The letter has been send.";
                    $data['status'] = PriceRequest::STATUS_CLOSED;
                }

                $model = $this->priceRequestRepository->getById($data['id']);
                $model->setData($data);
                $this->priceRequestRepository->save($model);

                $this->messageManager->addSuccessMessage(__($answer));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage("Price request answer fall: " . $e->getMessage());
            }
        }

        return $resultRedirect;
    }
}
