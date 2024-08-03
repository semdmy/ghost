<?php declare(strict_types=1);

namespace Ghost\Movie\Model\Api\SearchCriteria\JoinProcessor;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb;

class Director implements CollectionProcessorInterface
{
    public function process(SearchCriteriaInterface $searchCriteria, AbstractDb $collection)
    {
        $collection->getSelect()->joinLeft(
            'director',
            'main_table.director_id = director.director_id',
            'director.name as director_name'
        );
    }
}
