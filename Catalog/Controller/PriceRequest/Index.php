<?php

namespace Smile\Catalog\Controller\PriceRequest;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Smile\Customer\Model\PriceRequestFactory;
use Smile\Customer\Api\PriceRequestRepositoryInterface;

/**
 * Class Save
 *
 * @package Smile\Catalog\Controller\PriceRequest
 */
class Index extends Action
{
    /**
     ** @var PriceRequestFactory
     */
    protected $priceRequestFactory;

    /**
     ** @var RequestRepositoryInterface
     */
    protected $priceRequestRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param PriceRequestFactory $priceRequestFactory
     * @param PriceRequestRepositoryInterface $priceRequestRepository
     */
    public function __construct(
        Context $context,
        PriceRequestFactory $priceRequestFactory,
        PriceRequestRepositoryInterface $priceRequestRepository
	    ) {
        $this->priceRequestFactory = $priceRequestFactory;
        $this->priceRequestRepository = $priceRequestRepository;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return void
     *
     * @throws \Exception
     */
    public function execute()
    {
        try{
            if ($this->getRequest()->isAjax()) {
                $data = $this->getRequest()->getParams();

                $model = $this->priceRequestFactory->create();
                $model->setData($data);
                $this->priceRequestRepository->save($model);

                $this->messageManager->addSuccessMessage(__('Your request has been sent'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
}
