<?php declare(strict_types=1);

namespace Ghost\Movie\Model\Api\SearchCriteria\JoinProcessor;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb;

class Actor implements CollectionProcessorInterface
{
    public function process(SearchCriteriaInterface $searchCriteria, AbstractDb $collection)
    {
        $collection->getSelect()->joinLeft(
            'movie_actor',
            'movie_actor.movie_id = main_table.movie_id',
            null
        )->joinLeft(
            'actor',
            'movie_actor.actor_id = actor.actor_id',
            'name as actor_name'
        )->group('movie_actor.movie_id');
    }
}
