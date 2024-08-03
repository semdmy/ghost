<?php declare(strict_types=1);

namespace Ghost\Console\Console\Command;

use Magento\Framework\App\ResourceConnection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResourceTest extends Command
{
    public function __construct(
        protected ResourceConnection $resourceConnection,
        ?string                      $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('resource:test');
        $this->setDescription('Test resource');
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
//        $result = $this->fetchAll();
//        $result = $this->fetchCol();
//        $result = $this->fetchPairs();

        $result = $this->insertMovieData();

//        $result = $this->testJoins();

        $output->writeln(print_r($result, true));
        return 0;
    }

    public function testJoins(): array
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('movie');
        $select = $connection->select()
            ->from($tableName, ['movie_name' => 'name', 'rating' => 'rating'])
            ->joinRight(
                'director',
                $tableName . '.director_id=director.director_id',
                ['director_name' => 'name']
            );
        return $connection->fetchAll($select);
    }

    protected function fetchAll(): array
    {
        //Load movie table
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('movie');
        $select = $connection->select()
            ->from($tableName, ['description', 'rating'])
            ->join(
                'director',
                'movie.director_id=director.director_id',
                []
            )->where(
                'director.name=?', 'Hillary Clinton'
            );
        return $connection->fetchAssoc($select);
    }

    protected function fetchCol(): array
    {
        //Load movie column
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('movie');
        $select = $connection->select()
            ->from($tableName, [])
            ->where('rating=?', 4);
        return $connection->fetchCol($select);
    }

    protected function fetchPairs(): array
    {
        //Load movie column
        $connection = $this->resourceConnection->getConnection();
        $select = $connection->select()
            ->from(
                $connection->getTableName('movie'),
                []
            )
            ->joinLeft(
                $connection->getTableName('director'),
                'movie.director_id=director.director_id',
                ['name as director_name']
            )
            ->joinLeft(
                $connection->getTableName('movie_actor'),
                'movie_actor.movie_id=movie.movie_id',
                []
            )
            ->joinLeft(
                $connection->getTableName('actor'),
                'actor.actor_id=movie_actor.actor_id',
                ['name as actor_name']
            )
            ->where('director.name="Elon Mask"');
        return $connection->fetchPairs($select);


//        $tableName = $this->resourceConnection->getTableName('movie');
//        $rating = 33;
//        $bind = [':rating' => $rating];
//        $select = $connection->select()
//            ->from($tableName, ['name', 'description'])
//            ->where('rating=:rating');
//        return $connection->fetchPairs($select, $bind);
    }

    public function insertMovieData(): array
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('movie');
        $connection->update($tableName, $this->getNewMoviesdata());
        return $connection->fetchAll($connection->select()->from('movie'));
    }

    public function getNewMoviesdata(): array
    {
        return [
            [
                'movie_id' => 9,
                'name' => 'RickAndMorty1',
                'description' => 'Rick and Morty1',
                'rating' => 51,
                'director_id' => 2
            ]
        ];
    }
}
