<?php declare(strict_types=1);

namespace Ghost\Movie\Api;

use Ghost\Movie\Api\Data\MovieInterface;
use Ghost\Movie\Api\Data\MovieSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface MovieRepositoryInterface
{
    /**
     *
     * @param \Ghost\Movie\Api\Data\MovieInterface $movie
     * @return \Ghost\Movie\Api\Data\MovieInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(MovieInterface $movie): MovieInterface;

    /**
     * @param int $movieId
     * @return \Ghost\Movie\Api\Data\MovieInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $movieId): MovieInterface;

    /**
     * @param \Ghost\Movie\Api\Data\MovieInterface $movie
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(MovieInterface $movie): bool;

    /**
     * @param int $movieId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $movieId): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Ghost\Movie\Api\Data\MovieSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): MovieSearchResultsInterface;
}
