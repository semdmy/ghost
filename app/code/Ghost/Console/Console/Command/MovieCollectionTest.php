<?php

namespace Ghost\Console\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ghost\Movie\Model\ResourceModel\Movie\CollectionFactory as MovieCollectionFactory;

class MovieCollectionTest extends Command
{
    public function __construct(
        protected MovieCollectionFactory $movieCollectionFactory,
        ?string                          $name = null
    )
    {
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('movie-collection:test');
        $this->setDescription('Test collections');
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var \Ghost\Movie\Model\ResourceModel\Movie\Collection $movies */
        $movies = $this->movieCollectionFactory->create();
        $movies->addFieldToSelect('name', 'movie_name')
            ->addFilter('main_table.name', 'Pokemon')
            ->joinDirectors()
            ->joinActors();
        $output->writeln(print_r($movies->getItems(), true));
        return 0;
    }
}
