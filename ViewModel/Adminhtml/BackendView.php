<?php

namespace Algolia\AlgoliaSearch\ViewModel\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\LayoutInterface;
use Magento\Store\Model\StoreManagerInterface;

class BackendView
{
    /** @var RequestInterface */
    protected $request;

    /** @var LayoutInterface */
    protected $layout;

    /** @var StoreManagerInterface */
    protected $storeManager;

    /** @var TimezoneInterface */
    protected $dateTime;

    /** @var Session */
    protected $session;

    /** @var UrlInterface */
    protected $url;

    /**
     * @param RequestInterface $request
     * @param LayoutInterface $layout
     * @param StoreManagerInterface $storeManager
     * @param TimezoneInterface $dateTime
     * @param Session $session
     * @param UrlInterface $url
     */
    public function __construct(
        RequestInterface $request,
        LayoutInterface $layout,
        StoreManagerInterface $storeManager,
        TimezoneInterface $dateTime,
        Session $session,
        UrlInterface $url
    ) {
        $this->request = $request;
        $this->layout = $layout;
        $this->storeManager = $storeManager;
        $this->dateTime = $dateTime;
        $this->session = $session;
        $this->url = $url;
    }

    /** @return RequestInterface */
    public function getRequest()
    {
        return $this->request;
    }

    /** @return LayoutInterface */
    public function getLayout()
    {
        return $this->layout;
    }

    /** @return StoreManagerInterface */
    public function getStoreManager()
    {
        return $this->storeManager;
    }

    /** @return TimezoneInterface */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /** @return Session */
    public function getBackendSession()
    {
        return $this->session;
    }

    /** @return UrlInterface */
    public function getUrlInterface()
    {
        return $this->url;
    }

    /**
     * @param $message
     *
     * @return string
     */
    public function getTooltipHtml($message)
    {
        /** @var Template $block */
        $block = $this->getLayout()->createBlock(Template::class);

        $block->setTemplate('Algolia_AlgoliaSearch::ui/tooltip.phtml');
        $block->setData('message', $message);

        return $block->toHtml();
    }
}
