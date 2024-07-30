<?php

namespace Ghost\Console\Console\Command;

use Ghost\Movie\Api\MovieRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class GetListTest extends Command
{
    public function __construct(
        protected MovieRepositoryInterface $movieRepository,
        protected SearchCriteriaBuilder    $searchCriteriaBuilder,
        ?string                            $name = null)
    {
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('ghost-list:test');
        $this->setDescription('test get list method');
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->searchCriteriaBuilder->addFilter('rating', '4', 'eq');
        $collection = $this->movieRepository->getList($this->searchCriteriaBuilder->create());
        $output->writeln(print_r($collection->getItems(), true));
        return 0;
    }
}
