<?php


namespace src\Model;




class Movie
{
    private Int $Id_movie;
    private String $Name;
    private String $Poster;
    private String $Origin;
    private String $Vo;
    private String $Actors;
    private String $Director;
    private String $Genre;
    private \DateTime $Release_date;
    private String $Production;
    private Int $Runtime;
    private String $trailer;
    private String $Nomination;
    private String $Synopsis;
    private bool $Dvd;

    /**
     * @return Int
     */
    public function getIdMovie(): int
    {
        return $this->Id_movie;
    }

    /**
     * @param Int $Id_movie
     * @return Movie
     */
    public function setIdMovie(int $Id_movie): Movie
    {
        $this->Id_movie = $Id_movie;
        return $this;
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param String $Name
     * @return Movie
     */
    public function setName(string $Name): Movie
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @return String
     */
    public function getPoster(): string
    {
        return $this->Poster;
    }

    /**
     * @param String $Poster
     * @return Movie
     */
    public function setPoster(string $Poster): Movie
    {
        $this->Poster = $Poster;
        return $this;
    }

    /**
     * @return String
     */
    public function getOrigin(): string
    {
        return $this->Origin;
    }

    /**
     * @param String $Origin
     * @return Movie
     */
    public function setOrigin(string $Origin): Movie
    {
        $this->Origin = $Origin;
        return $this;
    }

    /**
     * @return String
     */
    public function getVo(): string
    {
        return $this->Vo;
    }

    /**
     * @param String $Vo
     * @return Movie
     */
    public function setVo(string $Vo): Movie
    {
        $this->Vo = $Vo;
        return $this;
    }

    /**
     * @return String
     */
    public function getActors(): string
    {
        return $this->Actors;
    }

    /**
     * @param String $Actors
     * @return Movie
     */
    public function setActors(string $Actors): Movie
    {
        $this->Actors = $Actors;
        return $this;
    }

    /**
     * @return String
     */
    public function getDirector(): string
    {
        return $this->Director;
    }

    /**
     * @param String $Director
     * @return Movie
     */
    public function setDirector(string $Director): Movie
    {
        $this->Director = $Director;
        return $this;
    }

    /**
     * @return String
     */
    public function getGenre(): string
    {
        return $this->Genre;
    }

    /**
     * @param String $Genre
     * @return Movie
     */
    public function setGenre(string $Genre): Movie
    {
        $this->Genre = $Genre;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate(): \DateTime
    {
        return $this->Release_date;
    }

    /**
     * @param \DateTime $Release_date
     * @return Movie
     */
    public function setReleaseDate(\DateTime $Release_date): Movie
    {
        $this->Release_date = $Release_date;
        return $this;
    }

    /**
     * @return String
     */
    public function getProduction(): string
    {
        return $this->Production;
    }

    /**
     * @param String $Production
     * @return Movie
     */
    public function setProduction(string $Production): Movie
    {
        $this->Production = $Production;
        return $this;
    }

    /**
     * @return Int
     */
    public function getRuntime(): int
    {
        return $this->Runtime;
    }

    /**
     * @param Int $Runtime
     * @return Movie
     */
    public function setRuntime(int $Runtime): Movie
    {
        $this->Runtime = $Runtime;
        return $this;
    }

    /**
     * @return String
     */
    public function getTrailer(): string
    {
        return $this->trailer;
    }

    /**
     * @param String $trailer
     * @return Movie
     */
    public function setTrailer(string $trailer): Movie
    {
        $this->trailer = $trailer;
        return $this;
    }

    /**
     * @return String
     */
    public function getNomination(): string
    {
        return $this->Nomination;
    }

    /**
     * @param String $Nomination
     * @return Movie
     */
    public function setNomination(string $Nomination): Movie
    {
        $this->Nomination = $Nomination;
        return $this;
    }

    /**
     * @return String
     */
    public function getSynopsis(): string
    {
        return $this->Synopsis;
    }

    /**
     * @param String $Synopsis
     * @return Movie
     */
    public function setSynopsis(string $Synopsis): Movie
    {
        $this->Synopsis = $Synopsis;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDvd(): bool
    {
        return $this->Dvd;
    }

    /**
     * @param bool $Dvd
     * @return Movie
     */
    public function setDvd(bool $Dvd): Movie
    {
        $this->Dvd = $Dvd;
        return $this;
    }






}