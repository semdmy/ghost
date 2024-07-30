<?php declare(strict_types=1);

namespace Ghost\Movie\Api\Data;

interface MovieInterface
{
    public const string TABLE_NAME = 'movie';
    public const string ID = 'movie_id';
    public const string NAME = 'name';
    public const string DESCRIPTION = 'description';
    public const string RATING = 'rating';
    public const string DIRECTOR_ID = 'director_id';
    public const string CREATED_AT = 'created_at';
    public const string UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getMovieId(): int;


    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return ?string
     */
    public function getDescription(): ?string;

    /**
     * @return ?int
     */
    public function getRating(): ?int;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return ?int
     */
    public function getDirectorId(): ?int;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param int $movieId
     * @return MovieInterface
     */
    public function setMovieId(int $movieId): MovieInterface;

    /**
     * @param string $name
     * @return MovieInterface
     */
    public function setName(string $name): MovieInterface;

    /**
     * @param string $description
     * @return MovieInterface
     */
    public function setDescription(string $description): MovieInterface;

    /**
     * @param ?int $rating
     * @return MovieInterface
     */
    public function setRating(?int $rating): MovieInterface;

    /**
     * @param int $directorId
     * @return MovieInterface
     */
    public function setDirectorId(int $directorId): MovieInterface;

    /**
     * @param string $createdAt
     * @return MovieInterface
     */
    public function setCreatedAt(string $createdAt): MovieInterface;

    /**
     * @param string $updatedAt
     * @return MovieInterface
     */
    public function setUpdatedAt(string $updatedAt): MovieInterface;
}
