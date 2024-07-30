<?php declare(strict_types=1);

namespace Ghost\Movie\Model;

use Ghost\Movie\Api\Data\MovieInterface;
use Ghost\Movie\Model\ResourceModel\Movie as MovieResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Movie extends AbstractModel implements MovieInterface, IdentityInterface
{
    public const string CACHE_TAG = 'Ghost_Movie';

    /**
     * @var string
     */
    protected $_eventPrefix = 'ghost_movie';

    /**
     * @var string
     */
    protected $_eventObject = 'ghost_movie';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(MovieResourceModel::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @inheritDoc
     */
    public function getMovieId(): int
    {
        return (int)$this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return (string)$this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->hasData(self::DESCRIPTION) ? (string)$this->getData(self::DESCRIPTION) : null;
    }

    /**
     * @inheritDoc
     */
    public function getRating(): ?int
    {
        return $this->hasData(self::RATING) ? (int)$this->getData(self::RATING) : null;
    }

    /**
     * @inheritDoc
     */
    public function getDirectorId(): ?int
    {
        return $this->hasData(self::DIRECTOR_ID) ? (int)$this->getData(self::DIRECTOR_ID) : null;
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return (string)$this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): string
    {
        return (string)$this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setMovieId(int $movieId): MovieInterface
    {
        $this->setData(self::ID, $movieId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): MovieInterface
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description): MovieInterface
    {
        $this->setData(self::DESCRIPTION, $description);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setRating(?int $rating): MovieInterface
    {
        $this->setData(self::RATING, $rating);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setDirectorId(int $directorId): MovieInterface
    {
        $this->setData(self::DIRECTOR_ID, $directorId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): MovieInterface
    {
        $this->setData(self::CREATED_AT, $createdAt);
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updatedAt): MovieInterface
    {
        $this->setData(self::UPDATED_AT, $updatedAt);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function beforeSave(): MovieInterface
    {
        if ($this->hasDataChanges()) {
            $this->setUpdatedAt(date('Y-m-d H:i:s'));
        }
        return parent::beforeSave();
    }
}
