<?php

namespace Algolia\AlgoliaSearch\Controller\Landingpage;

use Algolia\AlgoliaSearch\Helper\LandingPageHelper;
use Magento\Framework\App\ActionInterface;

class View implements ActionInterface
{
    /** @var \Magento\Framework\Controller\Result\ForwardFactory */
    protected $resultForwardFactory;

    /**
     * @var LandingPageHelper
     */
    protected $landingPageHelper;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        LandingPageHelper $landingPageHelper
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->landingPageHelper = $landingPageHelper;
    }

    /**
     * View CMS page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $pageId = $this->getRequest()->getParam('landing_page_id');

        $resultPage = $this->landingPageHelper->prepareResultPage($this, $pageId);
        if (!$resultPage) {
            $resultForward = $this->resultForwardFactory->create();

            return $resultForward->forward('noroute');
        }

        return $resultPage;
    }
}
