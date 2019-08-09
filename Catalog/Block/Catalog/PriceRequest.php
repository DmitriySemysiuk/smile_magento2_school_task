<?php

namespace Smile\Catalog\Block\Catalog;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

/**
 * Class PriceRequestButton
 *
 * @package Smile\Catalog\Block\Catalog
 */
class PriceRequest extends Template
{
    const PRICE_REQUEST_FORM_ACTION = 'catalog/pricerequest/save';

    protected $_registry;

    /**
     * PriceRequest constructor.
     * @param Template\Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(Template\Context $context, Registry $registry, array $data = [])
    {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get price request form action
     *
     * @return string
     */
    public function getFormAction(){
        return self::PRICE_REQUEST_FORM_ACTION;
    }

    /**
     * Get current category
     *
     * @return object
     */
    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category');
    }

    /**
     * Get current product
     *
     * @return object
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
}
