<?php declare(strict_types=1);

namespace Ghost\Movie\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface MovieSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Ghost\Movie\Api\Data\MovieInterface[]
     */
    public function getItems();

    /**
     * @param \Ghost\Movie\Api\Data\MovieInterface[] $items
     * @return MovieSearchResultsInterface
     */
    public function setItems(array $items);
}
