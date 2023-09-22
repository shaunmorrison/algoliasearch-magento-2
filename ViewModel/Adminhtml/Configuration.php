<?php

namespace Algolia\AlgoliaSearch\ViewModel\Adminhtml;

use Algolia\AlgoliaSearch\Helper\Configuration\AssetHelper;
use Algolia\AlgoliaSearch\Helper\Configuration\NoticeHelper;
use Algolia\AlgoliaSearch\Helper\AnalyticsHelper;

class Configuration implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /** @var AssetHelper */
    private $assetHelper;

    /** @var NoticeHelper */
    private $noticeHelper;

    /**
     * @var AnalyticsHelper
     */
    private $analyticsHelper;

    public function __construct(
        AssetHelper $assetHelper,
        NoticeHelper $noticeHelper,
        AnalyticsHelper $analyticsHelper
    ) {
        $this->assetHelper = $assetHelper;
        $this->noticeHelper = $noticeHelper;
        $this->analyticsHelper = $analyticsHelper;
    }

    /** @return bool */
    public function isClickAnalyticsEnabled()
    {
        return $this->analyticsHelper->isClickAnalyticsEnabled();
    }

    public function getLinksAndVideoTemplate($section)
    {
        return $this->assetHelper->getLinksAndVideoTemplate($section);
    }

    public function getExtensionNotices()
    {
        return $this->noticeHelper->getExtensionNotices();
    }

    public function getPersonalizationStatus()
    {
        return $this->noticeHelper->getPersonalizationStatus();
    }
}
