<?php

namespace Algolia\AlgoliaSearch\ViewModel\Adminhtml;

use Algolia\AlgoliaSearch\Helper\Configuration\AssetHelper;
use Algolia\AlgoliaSearch\Helper\Configuration\NoticeHelper;

class Configuration implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /** @var AssetHelper */
    protected $assetHelper;

    /** @var NoticeHelper */
    protected $noticeHelper;

    /**
     * @param AssetHelper $assetHelper
     * @param NoticeHelper $noticeHelper
     */
    public function __construct(
        AssetHelper $assetHelper,
        NoticeHelper $noticeHelper
    ) {
        $this->assetHelper = $assetHelper;
        $this->noticeHelper = $noticeHelper;
    }

    /** @return bool */
    public function isClickAnalyticsEnabled()
    {
        return $this->noticeHelper->isClickAnalyticsEnabled();
    }

    /**
     * @param $section
     * @return string
     */
    public function getLinksAndVideoTemplate($section)
    {
        return $this->assetHelper->getLinksAndVideoTemplate($section);
    }

    /**
     * @return array[]
     */
    public function getExtensionNotices()
    {
        return $this->noticeHelper->getExtensionNotices();
    }

    /**
     * @return int
     */
    public function getPersonalizationStatus()
    {
        return $this->noticeHelper->getPersonalizationStatus();
    }
}
