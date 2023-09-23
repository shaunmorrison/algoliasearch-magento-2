<?php

namespace Algolia\AlgoliaSearch\ViewModel\Recommend;

use Algolia\AlgoliaSearch\Helper\ConfigHelper;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Cart implements ArgumentInterface
{
    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * @param Session $checkoutSession
     * @param ConfigHelper $configHelper
     */
    public function __construct(
        Session $checkoutSession,
        ConfigHelper $configHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->configHelper = $configHelper;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAllCartItems()
    {
        $cartItems = [];
        $itemCollection = $this->checkoutSession->getQuote()->getAllVisibleItems();
        foreach ($itemCollection as $item) {
            $cartItems[] = $item->getProductId();
        }
        return array_unique($cartItems);
    }

    /**
     * @return array
     */
    public function getAlgoliaRecommendConfiguration()
    {
        return [
            'enabledFBTInCart' => $this->configHelper->isRecommendFrequentlyBroughtTogetherEnabledOnCartPage(),
            'enabledRelatedInCart' => $this->configHelper->isRecommendRelatedProductsEnabledOnCartPage(),
            'isTrendItemsEnabledInCartPage' => $this->configHelper->isTrendItemsEnabledInShoppingCart()
        ];
    }
}
