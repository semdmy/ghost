<?php

namespace Ghost\Console\Console\Command;

use Ghost\Movie\Api\Data\MovieInterface;
use Ghost\Movie\Api\MovieRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use \Magento\Framework\Api\Search\FilterGroup;
use tests\unit\Util\TestDataArrayBuilder;

class GetListTest extends Command
{
    public function __construct(
        protected MovieRepositoryInterface $movieRepository,
        protected SearchCriteriaBuilder    $searchCriteriaBuilder,
        protected FilterBuilder            $filterBuilder,
        protected FilterGroupBuilder       $filterGroupBuilder,
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
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $output->writeln(print_r($this->movieRepository->getList($searchCriteria)->getItems(), true));
        //$output->writeln(print_r($this->fieldsGroupsSearchCriteria(), true));
        return 0;
    }

    /**
     * @return MovieInterface[]
     * @throws LocalizedException
     */
    protected function fieldsGroupsSearchCriteria(): array
    {
        /** @var \Magento\Framework\Api\Filter $filter1 * */
        $filter1 = $this->filterBuilder->setField('description')
            ->setValue('ActionTast')
            ->setConditionType('like')
            ->create();
        /** @var \Magento\Framework\Api\Filter $filter2 * */
        $filter2 = $this->filterBuilder->setField('rating')
            ->setValue('4')
            ->setConditionType('eq')
            ->create();
        $filterGroup1 = $this->filterGroupBuilder->setFilters([
            $filter1,
            $filter2
        ])->create();
        $filter3 = $this->filterBuilder->setField('rating')
            ->setValue('33')
            ->setConditionType('eq')
            ->create();
        $filterGroup2 = $this->filterGroupBuilder->setFilters([
            $filter3
        ])->create();
//        $this->searchCriteriaBuilder->addFilters([$filter2]);
        $this->searchCriteriaBuilder->setFilterGroups([
            $filterGroup1,
            $filterGroup2
        ]);
        /** @var \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria */
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->movieRepository->getList($searchCriteria)->getItems();
    }
}
