<?php declare(strict_types=1);

namespace Ghost\Movie\Model\ResourceModel\Movie;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ghost\Movie\Model\Movie;
use Ghost\Movie\Model\ResourceModel\Movie as MovieResource;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(Movie::class, MovieResource::class);
    }

    public function joinDirectors()
    {
        $this->join(
            'director',
            'main_table.director_id = director.director_id',
            'name as director_name'
        );
        return $this;
    }

    public function joinActors()
    {
        $this->join(
            'movie_actor',
            'movie_actor.movie_id = main_table.movie_id',
            null
        )->join(
            'actor',
            'movie_actor.actor_id = actor.actor_id',
            'name as actor_name'
        );
        return $this;
    }

    public function joinActorData()
    {
        $this->joinActors();
        return $this;
    }
}
