<?php

namespace Algolia\AlgoliaSearch\Model;

use Algolia\AlgoliaSearch\Api\Data\LandingPageInterface;
use Magento\Framework\DataObject\IdentityInterface;

class LandingPage extends \Magento\Framework\Model\AbstractModel implements IdentityInterface, LandingPageInterface
{
    public const CACHE_TAG = 'algoliasearch_landing_page';

    protected $_cacheTag = 'algoliasearch_landing_page';

    protected $_eventPrefix = 'algoliasearch_landing_page';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Algolia\AlgoliaSearch\Model\ResourceModel\LandingPage::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return int|mixed|null
     */
    public function getLandingPageId()
    {
        return $this->getId();
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return (int) $this->getData(self::FIELD_STORE_ID);
    }

    /**
     * @return string
     */
    public function getUrlKey()
    {
        return (string) $this->getData(self::FIELD_URL_KEY);
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return (bool) $this->getData(self::FIELD_IS_ACTIVE);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (string) $this->getData(self::FIELD_TITLE);
    }

    /**
     * @return string
     */
    public function getDateFrom()
    {
        return (string) $this->getData(self::FIELD_DATE_FROM);
    }

    /**
     * @return string
     */
    public function getDateTo()
    {
        return (string) $this->getData(self::FIELD_DATE_TO);
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return (string) $this->getData(self::FIELD_META_TITLE);
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return (string) $this->getData(self::FIELD_META_DESCRIPTION);
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return (string) $this->getData(self::FIELD_META_KEYWORDS);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return (string) $this->getData(self::FIELD_CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function getQuery()
    {
        return (string) $this->getData(self::FIELD_QUERY);
    }

    /**
     * @return string
     */
    public function getConfiguration()
    {
        return (string) $this->getData(self::FIELD_CONFIGURATION);
    }

    /**
     * @return string
     */
    public function getCustomJs()
    {
        return (string) $this->getData(self::FIELD_CUSTOM_JS);
    }

    /**
     * @return string
     */
    public function getCustomCss()
    {
        return (string) $this->getData(self::FIELD_CUSTOM_CSS);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage'
     */
    public function setLandingPageId($value)
    {
        return $this->setId((int) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setStoreId($value)
    {
        return $this->setData(self::FIELD_STORE_ID, (int) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setUrlKey($value)
    {
        return $this->setData(self::FIELD_URL_KEY, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setIsActive($value)
    {
        return $this->setData(self::FIELD_IS_ACTIVE, (bool) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setTitle($value)
    {
        return $this->setData(self::FIELD_TITLE, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setDateFrom($value)
    {
        return $this->setData(self::FIELD_DATE_FROM, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setDateTo($value)
    {
        return $this->setData(self::FIELD_DATE_TO, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setMetaTitle($value)
    {
        return $this->setData(self::FIELD_META_TITLE, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setMetaDescription($value)
    {
        return $this->setData(self::FIELD_META_DESCRIPTION, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setMetaKeywords($value)
    {
        return $this->setData(self::FIELD_META_KEYWORDS, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setContent($value)
    {
        return $this->setData(self::FIELD_CONTENT, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setQuery($value)
    {
        return $this->setData(self::FIELD_QUERY, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setConfiguration($value)
    {
        return $this->setData(self::FIELD_CONFIGURATION, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setCustomJs($value)
    {
        return $this->setData(self::FIELD_CUSTOM_JS, (string) $value);
    }

    /**
     * @param $value
     * @return LandingPageInterface|LandingPage
     */
    public function setCustomCss($value)
    {
        return $this->setData(self::FIELD_CUSTOM_CSS, (string) $value);
    }

    /**
     * Check if landing page url key exists for specific store return page id if landing page exists
     * @param $identifier
     * @param $storeId
     * @param $date
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkIdentifier($identifier, $storeId, $date)
    {
        return $this->_getResource()->checkIdentifier($identifier, $storeId, $date);
    }
}
