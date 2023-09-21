<?php

namespace Algolia\AlgoliaSearch\Factory;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Module\Manager;
use Magento\Framework\ObjectManagerInterface;

class CatalogPermissionsFactory
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Manager
     */
    protected $moduleManager;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    protected $categoryPermissionsCollection;
    protected $productPermissionsCollection;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Manager $moduleManager
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Manager $moduleManager,
        ObjectManagerInterface $objectManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->moduleManager = $moduleManager;
        $this->objectManager = $objectManager;
    }

    /**
     * @param $storeId
     * @return bool
     */
    public function isCatalogPermissionsEnabled($storeId)
    {
        return $this->isCatalogPermissionsModuleEnabled()
            && $this->getCatalogPermissionsConfig()->isEnabled($storeId);
    }

    /**
     * @return bool
     */
    protected function isCatalogPermissionsModuleEnabled()
    {
        return $this->moduleManager->isEnabled('Magento_CatalogPermissions');
    }

    /**
     * @return \Magento\CatalogPermissions\Model\ResourceModel\Permission\Index|mixed
     */
    public function getPermissionsIndexResource()
    {
        return $this->objectManager->create('\Magento\CatalogPermissions\Model\ResourceModel\Permission\Index');
    }

    /**
     * @return \Magento\CatalogPermissions\Helper\Data|mixed
     */
    public function getCatalogPermissionsHelper()
    {
        return $this->objectManager->create('\Magento\CatalogPermissions\Helper\Data');
    }

    /**
     * @return \Magento\CatalogPermissions\App\Config|mixed
     */
    public function getCatalogPermissionsConfig()
    {
        return $this->objectManager->create('\Magento\CatalogPermissions\App\Config');
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCategoryPermissionsCollection()
    {
        if (!$this->categoryPermissionsCollection) {
            /** @var \Magento\CatalogPermissions\Model\ResourceModel\Permission\Index $indexResource */
            $indexResource = $this->getPermissionsIndexResource();
            $connection = $indexResource->getConnection();

            $select = $connection->select()
                ->from($indexResource->getMainTable(), [])
                ->columns('category_id')
                ->columns(['permissions' => new \Zend_Db_Expr("GROUP_CONCAT(CONCAT(customer_group_id, '_', grant_catalog_category_view) SEPARATOR ',')")])
                ->group('category_id');

            $this->categoryPermissionsCollection = $connection->fetchPairs($select);
        }

        return $this->categoryPermissionsCollection;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductPermissionsCollection()
    {
        if (!$this->productPermissionsCollection) {
            /** @var \Magento\CatalogPermissions\Model\ResourceModel\Permission\Index $indexResource */
            $indexResource = $this->getPermissionsIndexResource();
            $connection = $indexResource->getConnection();

            $select = $connection->select()
                ->from($indexResource->getTable([$indexResource->getMainTable(), 'product']), [])
                ->columns('product_id')
                ->columns(['permissions' => new \Zend_Db_Expr("GROUP_CONCAT(CONCAT(store_id, '_', customer_group_id, '_', grant_catalog_category_view) SEPARATOR ', ')")])
                ->group('product_id');

            $this->productPermissionsCollection = $connection->fetchPairs($select);
        }

        return $this->productPermissionsCollection;
    }
}
