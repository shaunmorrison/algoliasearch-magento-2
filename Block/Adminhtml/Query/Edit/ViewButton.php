<?php

namespace Algolia\AlgoliaSearch\Block\Adminhtml\Query\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ViewButton extends AbstractButton implements ButtonProviderInterface
{
    /**
     * @return array|void
     */
    public function getButtonData()
    {
        if ($this->getObjectQueryText()) {
            return [
                'label' => __('View'),
                'class' => 'view',
                'on_click' => sprintf("window.open('%s','_blank');", $this->getQueryTextViewUrl()),
                'sort_order' => 50,
            ];
        }
    }

    /**
     * Get action url
     * @return string
     */
    public function getQueryTextViewUrl()
    {
        if ($this->getObject()->getStoreId() != 0) {
            $this->frontendUrlBuilder->setScope($this->getObject()->getStoreId());
        }

        return rtrim($this->frontendUrlBuilder->getUrl('catalogsearch/result/?q=' . $this->getObjectQueryText()), '/');
    }
}
