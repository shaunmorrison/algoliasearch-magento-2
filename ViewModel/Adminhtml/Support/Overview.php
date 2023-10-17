<?php

namespace Algolia\AlgoliaSearch\ViewModel\Adminhtml\Support;

use Algolia\AlgoliaSearch\Helper\SupportHelper;
use Algolia\AlgoliaSearch\ViewModel\Adminhtml\BackendView;
use Magento\Backend\Block\Template;

class Overview implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /** @var BackendView */
    private $backendView;

    /** @var SupportHelper */
    private $supportHelper;

    /**
     * @param BackendView $backendView
     * @param SupportHelper $supportHelper
     */
    public function __construct(BackendView $backendView, SupportHelper $supportHelper)
    {
        $this->backendView = $backendView;
        $this->supportHelper = $supportHelper;
    }

    /** @return string */
    public function getApplicationId()
    {
        return $this->supportHelper->getApplicationId();
    }

    /**
     * @return string
     */
    public function getLegacyVersionHtml()
    {
        return $this->backendView->getLayout()->getBlock('support_legacy_version')
            ->setData('extension_version',$this->supportHelper->getExtensionVersion())->toHtml();
    }
}
