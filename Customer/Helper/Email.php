<?php

namespace Smile\Customer\Helper;

use Magento\Backend\App\Helper;
use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class Email extends AbstractHelper
{
    /**
     * Email template id
     */
    const EMAIL_TEMPLATE_ID = 'price_request_email_template';

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Email constructor.
     *
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Send email
     *
     * @param $data
     */
    public function sendEmail($data){
        $this->inlineTranslation->suspend();

        $transport = $this->transportBuilder
            ->setTemplateIdentifier(static::EMAIL_TEMPLATE_ID)
            ->setTemplateOptions(static::getOptions())
            ->setTemplateVars($data)
            ->setFrom(static::getSender())
            ->addTo($data['email'])
            ->getTransport();
        try {
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e->getMessage());
        }

        $this->inlineTranslation->resume();
    }

    /**
     * Get sender email data
     *
     * @return array
     */
    public function getSender() {
        return [
            'name' => $this->scopeConfig->getValue(
                'trans_email/ident_support/name',
                ScopeInterface::SCOPE_STORE
            ),
            'email' => $this->scopeConfig->getValue(
                'trans_email/ident_support/email',
                ScopeInterface::SCOPE_STORE
            )
        ];
    }

    /**
     * Get email options
     *
     * @return array
     */
    public function getOptions() {
        return [
            'area' => Area::AREA_ADMINHTML,
            'store' => Store::DEFAULT_STORE_ID
        ];
    }

}
