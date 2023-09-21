<?php

namespace Algolia\AlgoliaSearch\Block;

use Algolia\AlgoliaSearch\Helper\ConfigHelper;
use Magento\Framework\Data\CollectionDataSourceInterface;
use Magento\Framework\View\Element\Template;
use Magento\Search\Helper\Data as CatalogSearchHelper;

class TopSearch extends Template implements CollectionDataSourceInterface
{
    /**
     * @var ConfigHelper
     */
    protected $config;

    /**
     * @var CatalogSearchHelper
     */
    protected $catalogSearchHelper;

    /**
     * @param Template\Context $context
     * @param ConfigHelper $config
     * @param CatalogSearchHelper $catalogSearchHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ConfigHelper $config,
        CatalogSearchHelper $catalogSearchHelper,
        array $data = []
    ) {
        $this->config = $config;
        $this->catalogSearchHelper = $catalogSearchHelper;

        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isDefaultSelector()
    {
        return $this->config->isDefaultSelector();
    }

    /**
     * @return string
     */
    public function getResultUrl()
    {
        return $this->catalogSearchHelper->getResultUrl();
    }

    /**
     * @return string
     */
    public function getQueryParamName()
    {
        return $this->catalogSearchHelper->getQueryParamName();
    }
}
