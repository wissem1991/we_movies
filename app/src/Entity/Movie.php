<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;

class Movie
{
    private int $id;
    private string $title;
    private string $overview;
    private string $posterPath;
    private float $voteAverage;
    private int $voteCount;
    private DateTimeInterface $releaseDate;
    private ?Video $video = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return string
     */
    public function getPosterPath(): string
    {
        return $this->posterPath;
    }

    /**
     * @param string $posterPath
     */
    public function setPosterPath(string $posterPath): void
    {
        $this->posterPath = $posterPath;
    }

    /**
     * @return Video|null
     */
    public function getVideo(): ?Video
    {
        return $this->video;
    }

    /**
     * @param Video|null $video
     */
    public function setVideo(?Video $video): void
    {
        $this->video = $video;
    }

    /**
     * @return float
     */
    public function getVoteAverage(): float
    {
        return $this->voteAverage;
    }

    /**
     * @param float $voteAverage
     */
    public function setVoteAverage(float $voteAverage): void
    {
        $this->voteAverage = $voteAverage;
    }

    /**
     * @return float
     */
    public function getVoteCount(): float
    {
        return $this->voteCount;
    }

    /**
     * @param float $voteCount
     */
    public function setVoteCount(float $voteCount): void
    {
        $this->voteCount = $voteCount;
    }

    /**
     * @return DateTimeInterface
     */
    public function getReleaseDate(): DateTimeInterface
    {
        return $this->releaseDate;
    }

    /**
     * @param DateTimeInterface $releaseDate
     */
    public function setReleaseDate(DateTimeInterface $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }
}