<?php declare(strict_types=1);

namespace Ghost\Movie\Model;

use Ghost\Movie\Api\Data\MovieSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class MovieSearchResults extends SearchResults implements MovieSearchResultsInterface
{
}
