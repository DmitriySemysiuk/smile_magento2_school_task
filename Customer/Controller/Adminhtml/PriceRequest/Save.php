<?php

namespace Smile\Customer\Controller\Adminhtml\PriceRequest;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Smile\Customer\Api\PriceRequestRepositoryInterface;
use Smile\Customer\Model\PriceRequestFactory;


/**
 * Class Save
 *
 * @package Smile\Customer\Controller\Adminhtml\PriceRequest
 */
class Save extends Action
{
    /**
     ** Url path
     */
    const EDIT_URL = '*/*/edit';

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Customer::price_request_save';

    /**
     * Price Requests Closed Status
     */
    const STATUS_CLOSED = 3;

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
     * Save constructor
     *
     * @param Context          $context
     * @param DataPersistorInterface  $dataPersistor
     * @param PriceRequestRepositoryInterface $priceRequestRepository
     * @param PriceRequestFactory             $priceRequestFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        PriceRequestRepositoryInterface $priceRequestRepository,
        PriceRequestFactory $priceRequestFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->priceRequestRepository = $priceRequestRepository;
        $this->priceRequestFactory = $priceRequestFactory;
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

        $model = $this->priceRequestFactory->create();
        $data = $this->getRequest()->getParams();
        $answer = "";

        if ($data) {
            $oldStatus = $this->priceRequestRepository->getById($data['id']);
            if ($oldStatus->getStatus() != static::STATUS_CLOSED) {
                if ($data['status'] == static::STATUS_CLOSED ||
                    ($data['status'] != static::STATUS_CLOSED && $data['answer'] != null)) {
                    try {
                        if ($data['status'] != static::STATUS_CLOSED) {

                            //email

                            $answer = $answer . 'Letter sent';
                            $data['status'] = self::STATUS_CLOSED;
                        }

                        $model->setData($data);
                        $answer = $answer . '   Request closed';
                        $this->priceRequestRepository->save($model);

                        $this->messageManager->addSuccessMessage(__($answer));
                    } catch (\Exception $e) {
                        $this->messageManager->addErrorMessage($e->getMessage());

                        $resultRedirect->setPath($this->getUrl(static::EDIT_URL, [$data['id']]));
                    }
                }
            }
            else {
                $answer = 'Request was closed long time ago';
                $this->messageManager->addSuccessMessage(__($answer));
            }
        }

        return $resultRedirect;
    }

    /**
     * Is the user allowed to save the customer price request answer.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}
