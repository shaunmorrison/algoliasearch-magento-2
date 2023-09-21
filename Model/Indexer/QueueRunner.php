<?php

namespace Algolia\AlgoliaSearch\Model\Indexer;

use Algolia\AlgoliaSearch\Helper\ConfigHelper;
use Algolia\AlgoliaSearch\Model\Queue;
use Magento\Framework\Message\ManagerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;

class QueueRunner implements \Magento\Framework\Indexer\ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    public const INDEXER_ID = 'algolia_queue_runner';

    /**
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var ConsoleOutput
     */
    protected $output;

    /**
     * @param ConfigHelper $configHelper
     * @param Queue $queue
     * @param ManagerInterface $messageManager
     * @param ConsoleOutput $output
     */
    public function __construct(
        ConfigHelper $configHelper,
        Queue $queue,
        ManagerInterface $messageManager,
        ConsoleOutput $output
    ) {
        $this->configHelper = $configHelper;
        $this->queue = $queue;
        $this->messageManager = $messageManager;
        $this->output = $output;
    }

    /**
     * @param $ids
     * @return $this|void
     */
    public function execute($ids)
    {
        return $this;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function executeFull()
    {
        if (!$this->configHelper->getApplicationID()
            || !$this->configHelper->getAPIKey()
            || !$this->configHelper->getSearchOnlyAPIKey()) {
            $errorMessage = 'Algolia reindexing failed:
                You need to configure your Algolia credentials in Stores > Configuration > Algolia Search.';

            if (php_sapi_name() === 'cli') {
                $this->output->writeln($errorMessage);

                return;
            }

            $this->messageManager->addErrorMessage($errorMessage);

            return;
        }

        $this->queue->runCron();
    }

    /**
     * @param array $ids
     * @return $this|void
     */
    public function executeList(array $ids)
    {
        return $this;
    }

    /**
     * @param $id
     * @return $this|void
     */
    public function executeRow($id)
    {
        return $this;
    }
}
