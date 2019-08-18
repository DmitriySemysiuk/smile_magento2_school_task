<?php

namespace Smile\Customer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class PriceRequest
 *
 * @package Smile\Customer\Model\ResourceModel
 */
class PriceRequest extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('customer_price_request', 'id');
    }
}
