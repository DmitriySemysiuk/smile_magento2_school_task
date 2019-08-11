<?php

namespace Smile\Customer\Block\Adminhtml\PriceRequest\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SendEmailButton
 *
 * @package Smile\Customer\Block\Adminhtml\PriceRequest\Edit
 */
class SendEmailButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Url path
     */
    const SEND_EMAIL_URL = 'smile_customer/pricerequest/sendemail';

    /**
     * Get SendEmailButton button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Send email'),
            'class' => 'primary',
            'on_click' => sprintf("location.href = '%s';", $this->getSendEmailUrl()),
            'sort_order' => 30,
        ];
    }

    /**
     * Get URL for send email button
     *
     * @return string
     */
    public function getSendEmailUrl()
    {
        return $this->getUrl(self::SEND_EMAIL_URL);
    }
}
