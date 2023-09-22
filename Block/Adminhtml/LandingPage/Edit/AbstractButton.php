<?php

namespace Algolia\AlgoliaSearch\Block\Adminhtml\LandingPage\Edit;

use Algolia\AlgoliaSearch\Block\Adminhtml\LandingPage\Renderer\UrlBuilder;
use Algolia\AlgoliaSearch\Model\LandingPage;
use Algolia\AlgoliaSearch\Model\LandingPageFactory;
use Magento\Backend\Block\Widget\Context;

abstract class AbstractButton
{
    /** @var Context */
    protected $context;

    /** @var LandingPageFactory */
    protected $landingPageFactory;

    /** @var UrlBuilder */
    protected $frontendUrlBuilder;

    /**
     * @param Context $context
     * @param LandingPageFactory $landingPageFactory
     * @param UrlBuilder $frontendUrlBuilder
     */
    public function __construct(
        Context $context,
        LandingPageFactory $landingPageFactory,
        UrlBuilder $frontendUrlBuilder
    ) {
        $this->context = $context;
        $this->landingPageFactory = $landingPageFactory;
        $this->frontendUrlBuilder = $frontendUrlBuilder;
    }

    /**
     * Return object
     * @return LandingPage|null
     */
    public function getObject()
    {
        try {
            $modelId = $this->context->getRequest()->getParam('id');
            /** @var LandingPage $landingPage */
            $landingPage = $this->landingPageFactory->create();
            $landingPage->getResource()->load($landingPage, $modelId);

            return $landingPage;
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
        }

        return null;
    }

    /**
     * Return object ID
     * @return mixed|null
     */
    public function getObjectId()
    {
        return $this->getObject() ? $this->getObject()->getId() : null;
    }

    /**
     * Return url key
     * @return string|null
     */
    public function getObjectUrlKey()
    {
        return $this->getObject() ? $this->getObject()->getUrlKey() : null;
    }

    /**
     * Generate url by route and parameters
     * @param $route
     * @param $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
    * get the button data
     * @return mixed
     */
    abstract public function getButtonData();
}
