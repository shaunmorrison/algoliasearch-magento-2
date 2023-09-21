<?php

namespace Algolia\AlgoliaSearch\Helper;

use Algolia\AlgoliaSearch\Model\LandingPage;
use Algolia\AlgoliaSearch\Model\LandingPageFactory;
use Magento\Framework\Registry;
use Magento\Framework\App\ActionInterface;

/**
 * Landing Page Helper
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class LandingPageHelper extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var LandingPage */
    protected $landingPage;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    /** @var LandingPageFactory */
    protected $landingPageFactory;

    /** @var \Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory;

    /** @var Registry */
    protected $registry;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param LandingPage $landingPage
     * @param LandingPageFactory $landingPageFactory
     * @param Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        LandingPage $landingPage,
        LandingPageFactory $landingPageFactory,
        Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->landingPage = $landingPage;
        $this->landingPageFactory = $landingPageFactory;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @param $pageId
     * @return LandingPage|false
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLandingPage($pageId)
    {
        if ($pageId !== null && $pageId !== $this->landingPage->getId()) {
            $this->landingPage->setStoreId($this->storeManager->getStore()->getId());
            if (!$this->landingPage->load($pageId)) {
                return false;
            }
            $this->registry->register('current_landing_page', $this->landingPage);
        }

        return $this->landingPage;
    }

    /**
     * Return result Landing page
     *
     * @param ActionInterface $action
     * @param null $pageId
     *
     * @return \Magento\Framework\View\Result\Page|bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareResultPage(ActionInterface $action, $pageId = null)
    {
        $page = $this->getLandingPage($pageId);

        if (!$page->getId()) {
            return false;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addHandle('algolia_algoliasearch_landingpage_view');
        $resultPage->addPageLayoutHandles(
            ['id' => str_replace('/', '_', $page->getUrlKey())]
        );

        $this->_eventManager->dispatch(
            'algolia_landingpage_render',
            ['page' => $this->landingPage, 'controller_action' => $action, 'request' => $this->_getRequest()]
        );

        return $resultPage;
    }

    /**
     * Retrieve landing page direct URL
     *
     * @param null $pageId
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPageUrl($pageId = null)
    {
        $page = $this->getLandingPage($pageId);

        if (!$page->getId()) {
            return false;
        }

        return $this->_urlBuilder->getUrl(null, ['_direct' => $page->getUrlKey()]);
    }
}
