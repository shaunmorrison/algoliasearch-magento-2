<?php

namespace Algolia\AlgoliaSearch\Model\Backend;

use Algolia\AlgoliaSearch\Exceptions\AlgoliaException;
use Algolia\AlgoliaSearch\Helper\AlgoliaHelper;
use Algolia\AlgoliaSearch\Helper\ConfigHelper;
use Algolia\AlgoliaSearch\Helper\Data;
use Algolia\AlgoliaSearch\Helper\Entity\ProductHelper;
use Algolia\AlgoliaSearch\Model\IndicesConfigurator;
use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;

class Sorts extends ArraySerialized
{
    /** @var StoreManagerInterface */
    protected $storeManager;

    /** @var IndicesConfigurator */
    protected $indicesConfigurator;

    /**
     * @var AlgoliaHelper
     */
    protected $algoliaHelper;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var ProductHelper
     */
    protected $productHelper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param StoreManagerInterface $storeManager
     * @param IndicesConfigurator $indicesConfigurator
     * @param AlgoliaHelper $algoliaHelper
     * @param Data $helper
     * @param ProductHelper $productHelper
     * @param array $data
     * @param Json|null $serializer
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        StoreManagerInterface $storeManager,
        IndicesConfigurator $indicesConfigurator,
        AlgoliaHelper $algoliaHelper,
        Data $helper,
        ProductHelper $productHelper,
        ConfigHelper $configHelper,
        array $data = [],
        Json $serializer = null
    ) {
        $this->storeManager = $storeManager;
        $this->indicesConfigurator = $indicesConfigurator;
        $this->algoliaHelper = $algoliaHelper;
        $this->helper = $helper;
        $this->productHelper = $productHelper;
        $this->config = $configHelper;
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }
    /**
     * @return $this
     */
    public function afterSave()
    {
        if ($this->isValueChanged()) {
            $oldValue = $this->serializer->unserialize($this->getOldValue());
            $storeIds = array_keys($this->storeManager->getStores());
            foreach ($storeIds as $storeId) {
                $indexName = $this->helper->getIndexName($this->productHelper->getIndexNameSuffix(), $storeId);
                $sortingIndices = $this->config->getSortingIndices($indexName, $storeId, null, $oldValue);
                if ($this->config->isInstantEnabled($storeId)) {
                    $replicas = array_values(array_map(function ($sortingIndex) {
                        return $sortingIndex['name'];
                    }, $sortingIndices));
                    try {
                        if ($this->config->useVirtualReplica($storeId)) {
                            $replicas = $this->productHelper->handleVirtualReplica($replicas, $indexName);
                        }
                        $currentSettings = $this->algoliaHelper->getSettings($indexName);
                        if (is_array($currentSettings) && array_key_exists('replicas', $currentSettings)) {
                            $replicasRequired = array_values(array_diff_assoc($currentSettings['replicas'], $replicas));
                            $this->algoliaHelper->setSettings($indexName, ['replicas' => $replicasRequired]);
                            $setReplicasTaskId = $this->algoliaHelper->getLastTaskId();
                            $this->algoliaHelper->waitLastTask($indexName, $setReplicasTaskId);
                            if (count($replicas) > 0) {
                                foreach ($replicas as $replicaIndex) {
                                    $this->algoliaHelper->deleteIndex($replicaIndex);
                                }
                            }
                        }
                    } catch (AlgoliaException $e) {
                        if ($e->getCode() !== 404) {
                            throw $e;
                        }
                    }
                }
            }
        }
        return parent::afterSave();
    }
}

