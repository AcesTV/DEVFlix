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
    private String $Release_date; //Datetime
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
     * @return String
     */
    public function getReleaseDate(): String
    {
        return $this->Release_date;
    }

    /**
     * @param String $Release_date
     * @return Movie
     */
    public function setReleaseDate(String $Release_date): Movie
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


    public function SQLGetOne(\PDO $bdd, $id) {
        $requete = $bdd->prepare("SELECT * FROM t_movies WHERE ID_MOVIE=:ID");
        $requete->execute([
            "ID" => $id
        ]);
        return $requete->fetch();
    }

    public function SQLGetAll(\PDO $bdd)
    {
        $requete = $bdd->prepare("SELECT * FROM t_movies");
        $requete->execute();
        return $requete->fetchAll(\PDO::FETCH_CLASS, "src\Model\Movie");
    }

    public function SQLAddMovie(\PDO $bdd) : array
    {
        try{
            $requete = $bdd->prepare("INSERT INTO t_movies (NAME, POSTER, ORIGIN, VO, ACTORS, DIRECTOR, GENRE, RELEASE_DATE, PRODUCTION, RUNTIME, TRAILER, NOMINATION, SYNOPSIS, DVD) VALUES (:NAME, :POSTER, :ORIGIN, :VO, :ACTORS, :DIRECTOR, :GENRE, :RELEASE_DATE, :PRODUCTION, :RUNTIME, :TRAILER, :NOMINATION, :SYNOPSIS, :DVD)");
            $requete->execute([
                "NAME" => $this->getName(),
                "POSTER" => $this->getPoster(),
                "ORIGIN" => $this->getOrigin(),
                "VO" => $this->getVo(),
                "ACTORS" => $this->getActors(),
                "DIRECTOR" => $this->getDirector(),
                "GENRE" => $this->getGenre(),
                "RELEASE_DATE" => $this->getReleaseDate(),
                "PRODUCTION" => $this->getProduction(),
                "RUNTIME" => $this->getRuntime(),
                "TRAILER" => $this->getTrailer(),
                "NOMINATION" => $this->getNomination(),
                "SYNOPSIS" => $this->getSynopsis(),
                "DVD" => ($this->isDvd() ==  false) ? 0 : 1
            ]);

            //Si tous se passe bien return True
            return [true,"Ajout du film réussie !"];

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }
    }

    public function SQLUpdateMovie(\PDO $bdd, $id) : array
    {
        try{
            $requete = $bdd->prepare("UPDATE t_movies SET NAME=:NAME, POSTER=:POSTER, ORIGIN=:ORIGIN, VO=:VO, ACTORS=:ACTORS, DIRECTOR=:DIRECTOR, GENRE=:GENRE, RELEASE_DATE=:RELEASE_DATE, PRODUCTION=:PRODUCTION, RUNTIME=:RUNTIME, TRAILER=:TRAILER, NOMINATION=:NOMINATION, SYNOPSIS=:SYNOPSIS, DVD=:DVD WHERE ID_MOVIE=:ID");

            $reponse = $requete->execute([
                "ID" => $id,
                "NAME" => $this->getName(),
                "POSTER" => $this->getPoster(),
                "ORIGIN" => $this->getOrigin(),
                "VO" => $this->getVo(),
                "ACTORS" => $this->getActors(),
                "DIRECTOR" => $this->getDirector(),
                "GENRE" => $this->getGenre(),
                "RELEASE_DATE" => $this->getReleaseDate(),
                "PRODUCTION" => $this->getProduction(),
                "RUNTIME" => $this->getRuntime(),
                "TRAILER" => $this->getTrailer(),
                "NOMINATION" => $this->getNomination(),
                "SYNOPSIS" => $this->getSynopsis(),
                "DVD" => ($this->isDvd() ==  false) ? 0 : 1
            ]);
            //Si tous se passe bien return True
            return [true,"Modification du film réussie !"];

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }
    }

    public function SQLDeleteMovie(\PDO $bdd, $id) : array
    {
        try{
            $requete = $bdd->prepare("DELETE FROM t_info_movies WHERE ID_MOVIE=:ID");
            $requete->execute([
                "ID" => $id,
            ]);
            $requete = $bdd->prepare("DELETE FROM t_movies WHERE ID_MOVIE=:ID");
            $requete->execute([
                "ID" => $id,
            ]);
            //Si tous se passe bien return True
            return [true,"Supression du film réussie !"];

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }
    }

}