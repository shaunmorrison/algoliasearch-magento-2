<?php

namespace Algolia\AlgoliaSearch\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Logger
{
    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var ConfigHelper
     */
    protected $config;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var array
     */
    protected $timers = [];

    /**
     * @var array
     */
    protected $stores = [];

    /**
     * @param StoreManagerInterface $storeManager
     * @param ConfigHelper $configHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ConfigHelper $configHelper,
        LoggerInterface $logger
    ) {
        $this->config = $configHelper;
        $this->enabled = $this->config->isLoggingEnabled();
        $this->logger = $logger;

        foreach ($storeManager->getStores() as $store) {
            $this->stores[$store->getId()] = $store->getName();
        }
    }

    /**
     * @return bool
     */
    public function isEnable()
    {
        return $this->enabled;
    }

    /**
     * @param $storeId
     * @return string
     */
    public function getStoreName($storeId)
    {
        if ($storeId === null) {
            return 'undefined store';
        }

        return $storeId . ' (' . $this->stores[$storeId] . ')';
    }

    /**
     * @param $action
     * @return void
     */
    public function start($action)
    {
        if ($this->enabled === false) {
            return;
        }

        $this->log('');
        $this->log('');
        $this->log('>>>>> BEGIN ' . $action);
        $this->timers[$action] = microtime(true);
    }

    /**
     * @param $action
     * @return void
     * @throws \Exception
     */
    public function stop($action)
    {
        if ($this->enabled === false) {
            return;
        }

        if (false === isset($this->timers[$action])) {
            throw new \Exception('Algolia Logger => non existing action');
        }

        $this->log('<<<<< END ' . $action . ' (' . $this->formatTime($this->timers[$action], microtime(true)) . ')');
    }

    /**
     * @param $message
     * @return void
     */
    public function log($message)
    {
        if ($this->enabled) {
            $this->logger->info($message);
        }
    }

    /**
     * @param $begin
     * @param $end
     * @return string
     */
    protected function formatTime($begin, $end)
    {
        return ($end - $begin) . 'sec';
    }
}
