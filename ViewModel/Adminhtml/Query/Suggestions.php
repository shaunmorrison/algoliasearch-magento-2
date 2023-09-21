<?php

namespace Algolia\AlgoliaSearch\ViewModel\Adminhtml\Query;

use Algolia\AlgoliaSearch\Model\ResourceModel\Query\CollectionFactory as QueryCollectionFactory;

class Suggestions implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /** @var QueryCollectionFactory */
    protected $queryCollectionFactory;

    /**
     * @param QueryCollectionFactory $queryCollectionFactory
     */
    public function __construct(QueryCollectionFactory $queryCollectionFactory)
    {
        $this->queryCollectionFactory = $queryCollectionFactory;
    }

    /**
     * @return mixed
     */
    public function getNbOfQueries()
    {
        $queryCollection = $this->queryCollectionFactory->create();

        return $queryCollection->getSize();
    }
}
