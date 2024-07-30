<?php declare(strict_types=1);

namespace Ghost\Movie\Model;

use Ghost\Movie\Api\Data\MovieInterface;
use Ghost\Movie\Api\Data\MovieSearchResultsInterface;
use Ghost\Movie\Api\Data\MovieSearchResultsInterfaceFactory;
use Ghost\Movie\Api\MovieRepositoryInterface;
use Ghost\Movie\Model\ResourceModel\Movie as MovieResource;
use Ghost\Movie\Model\ResourceModel\Movie\CollectionFactory as MovieCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class MovieRepository implements MovieRepositoryInterface
{
    public function __construct(
        protected MovieResource                      $movieResource,
        protected MovieFactory                       $movieFactory,
        protected MovieCollectionFactory             $movieCollectionFactory,
        protected CollectionProcessorInterface       $collectionProcessor,
        protected MovieSearchResultsInterfaceFactory $movieSearchResultsFactory,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function save(MovieInterface $movie): MovieInterface
    {
        try {
            $this->movieResource->save($movie);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $movie;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $movieId): MovieInterface
    {
        try {
            $movie = $this->movieFactory->create();
            $this->movieResource->load($movie, $movieId);
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__('The movie could  not be found'));
        }
        return $movie;
    }

    /**
     * @inheritDoc
     */
    public function delete(MovieInterface $movie): bool
    {
        try {
            $this->movieResource->delete($movie);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $movieId): bool
    {
        return $this->delete($this->getById($movieId));
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): MovieSearchResultsInterface
    {
        $collection = $this->movieCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var MovieSearchResultsInterface $searchResults * */
        $searchResults = $this->movieSearchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
