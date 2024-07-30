<?php

namespace Ghost\Console\Console\Command;

use Magento\Framework\Exception\AlreadyExistsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ghost\Movie\Model\MovieFactory;
use Ghost\Movie\Model\ResourceModel\Movie as MovieResource;

class MovieResourceTest extends Command
{
    public function __construct(
        protected MovieFactory  $movieFactory,
        protected MovieResource $movieResource,
        ?string                 $name = null
    )
    {
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('movie-resource:test');
        $this->setDescription('description ...');
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws AlreadyExistsException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $movie = $this->movieFactory->create();
        $movie->setName('asdsadasdas')
            ->setDescription('asdf')
            ->setRating(3)
            ->setCreatedAt('2001-04-04')
            ->setUpdatedAt(date('Y-m-d H:i:s'));
        $this->movieResource->save($movie);
        $output->writeln(print_r($movie->getData(), true));
        return 0;
    }
}
