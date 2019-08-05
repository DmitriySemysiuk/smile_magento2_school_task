<?php

namespace Smile\Customer\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\Customer\Api\PriceRequestRepositoryInterface;

use Smile\Customer\Api\Data;
use Smile\Customer\Model\ResourceModel\PriceRequest as ResourcePriceRequest;
use Smile\Customer\Model\ResourceModel\PriceRequest\CollectionFactory as PriceRequestCollectionFactory;


class PriceRequestRepository implements PriceRequestRepositoryInterface
{
    /**
     * Resource PriceRequest
     *
     * @var \Smile\Customer\Model\ResourceModel\PriceRequest
     */
    private $resource;

    /**
     * PriceRequest factory
     *
     * @var PriceRequestFactory
     */
    private $priceRequestFactory;

    /**
     * PriceRequest collection factory
     *
     *@var \Smile\Customer\Model\ResourceModel\PriceRequest\CollectionFactory
     */
    private $priceRequestCollectionFactory;

    /**
     * PriceRequest search results interface factory
     *
     * @var PriceRequestSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;


    public function __construct(
        ResourcePriceRequest $resource,
        PriceRequestFactory $priceRequestFactory,
        PriceRequestCollectionFactory $priceRequestCollectionFactory,
        Data\PriceRequestSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->priceRequestFactory = $priceRequestFactory;
        $this->priceRequestCollectionFactory = $priceRequestCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param \Smile\Customer\Api\Data\PriceRequestInterface $priceRequest
     *
     * @return PriceRequest
     *
     * @throws CouldNotSaveException
     */
    public function save(Data\PriceRequestInterface $priceRequest)
    {
        try {
            $this->resource->save($priceRequest);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $priceRequest;
    }

    /**
     * Load PriceRequest data by given PriceRequest Identity
     *
     * @param string $priceRequestId
     *
     * @return Post
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($priceRequestId)
    {
        $priceRequest = $this->priceRequestFactory->create();
        $this->resource->load($priceRequest, $priceRequestId);
        if (!$priceRequest->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $priceRequestId));
        }

        return $priceRequest;
    }

    /**
     * Load PriceRequest data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     *
     * @return \Smile\Customer\Model\ResourceModel\PriceRequest\Collection
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getList(SearchCriteriaInterface $criteria = null)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->priceRequestCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $priceRequest = [];
        /** @var Data\PriceRequestInterface $priceRequestModel */
        foreach ($collection as $priceRequestModel) {
            $priceRequest[] = $priceRequestModel;
        }
        $searchResults->setItems($priceRequest);

        return $searchResults;
    }

    /**
     * Delete PriceRequest
     *
     * @param \Smile\Customer\Api\Data\PriceRequestInterface $priceRequest
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     */
    public function delete(Data\PriceRequestInterface $priceRequest)
    {
        try {
            $this->resource->delete($priceRequest);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete PriceRequest by given PriceRequest Identity
     *
     * @param string $priceRequestId
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($priceRequestId)
    {
        return $this->delete($this->getById($priceRequestId));
    }
}
