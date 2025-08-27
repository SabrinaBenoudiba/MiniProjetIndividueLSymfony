<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $movieTitle = null;

    #[ORM\Column]
    private ?int $yearReleased = null;

    #[ORM\Column]
    private ?int $movieDuration = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?movieDirector $filmography = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieTitle(): ?string
    {
        return $this->movieTitle;
    }

    public function setMovieTitle(string $movieTitle): static
    {
        $this->movieTitle = $movieTitle;

        return $this;
    }

    public function getYearReleased(): ?int
    {
        return $this->yearReleased;
    }

    public function setYearReleased(int $yearReleased): static
    {
        $this->yearReleased = $yearReleased;

        return $this;
    }

    public function getMovieDuration(): ?int
    {
        return $this->movieDuration;
    }

    public function setMovieDuration(int $movieDuration): static
    {
        $this->movieDuration = $movieDuration;

        return $this;
    }

    public function getFilmography(): ?movieDirector
    {
        return $this->filmography;
    }

    public function setFilmography(?movieDirector $filmography): static
    {
        $this->filmography = $filmography;

        return $this;
    }
}
