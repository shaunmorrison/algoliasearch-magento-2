<?php

namespace Algolia\AlgoliaSearch\Block\Adminhtml\LandingPage\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ViewButton extends AbstractButton implements ButtonProviderInterface
{
    /**
     * @return array|void
     */
    public function getButtonData()
    {
        if ($this->getObjectUrlKey()) {
            return [
                'label' => __('View'),
                'class' => 'view',
                'on_click' => sprintf("window.open('%s','_blank');", $this->getLandingPageUrl()),
                'sort_order' => 50,
            ];
        }
    }

    /**
     * Get action url
     * @return string
     */
    public function getLandingPageUrl()
    {
        if ($this->getObject()->getStoreId() != 0) {
            $this->frontendUrlBuilder->setScope($this->getObject()->getStoreId());
        }

        return $this->frontendUrlBuilder->getUrl($this->getObjectUrlKey());
    }
}
