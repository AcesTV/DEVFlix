<?php
namespace src\Model;
session_start();

//use Twig\Extension\StringLoaderExtension;

class InfoMovie
{
    private Int $Id_info;
    private Int $Id_movie;
    private Int $Id_user;
    private Float $Rate;
    private String $Comment;
//    private bool $Share;
//    private bool $See;
//    private bool $To_see;

    //Fonctions SQL

    //Fonction SQLAjout
    public function SQLAddInfoMovie(\PDO $bdd) : array{

        try{
//            $requete = $bdd->prepare("INSERT INTO t_info_movies (ID_MOVIE, ID_USER, RATE, COMMENT, SHARE, SEE, TO_SEE) VALUES(:ID_MOVIE, :ID_USER, :RATE, :COMMENT, :SHARE, :SEE, :TO_SEE)");
            $requete = $bdd->prepare("INSERT INTO t_info_movies (ID_MOVIE, ID_USER, RATE, COMMENT) VALUES(:ID_MOVIE, :ID_USER, :RATE, :COMMENT)");
            $requete->execute([
//                "ID_MOVIE" => $_GET["param"],
                "ID_MOVIE" => 1, //TODO à supprimer à la fin des tests
//                "ID_USER" => $_SESSION["ID"],  // TODO pr le moment je n'arrive pas à me logger
                "ID_USER" => 1,
                "RATE" => $this->getRate(),
                "COMMENT" => $this->getComment(),
//                "SHARE" => $this->getInfoMovieSHARE(),
//                "SEE" => $this->getInfoMovieSEE(),
//                "TO_SEE" => $this->getInfoMovieTO_SEE(),
            ]);

            //Si tous se passe bien return True
            return [true,"Ajout de votre commentaire effectué"];

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }
    }
    public function SQLGetOne(\PDO $bdd, $id) {
        $requete = $bdd->prepare("SELECT * FROM t_info_movies WHERE ID_INFO=:ID");
        $requete->execute([
            "ID" => $id
        ]);
        return $requete->fetch();
    }
    //Fonction SQLUpDadeInfoMovie
    public function SQLUpdateInfoMovie(\PDO $bdd, $id) : array{

        try{
//            $requete = $bdd->prepare("UPDATE t_info_movies SET ID_MOVIE:=ID_MOVIE, ID_USER=:ID_USER, RATE=RATE:, COMMENT=:COMMENT, SHARE=:SHARE, SEE=:SEE, TO_SEE=:TO_SEE WHERE ID_INFO=:ID");
            $requete = $bdd->prepare("UPDATE t_info_movies SET ID_MOVIE=:ID_MOVIE, ID_USER=:ID_USER, RATE=:RATE, COMMENT=:COMMENT WHERE ID_INFO=:ID");
            $reponse = $requete->execute([
                "ID" => $id,
//                "ID_MOVIE" => $this->getInfoMovieID_MOVIE(),
                "ID_MOVIE" => 1,
//                "ID_USER" => $_SESSION["ID_USER"],
                "ID_USER" => 1,
                "RATE" => $this->getRate(),
                "COMMENT" => $this->getComment(),
//                "SHARE" => $this->getInfoMovieSHARE(),
//                "SEE" => $this->getInfoMovieSEE(),
//                "TO_SEE" => $this->getInfoMovieTO_SEE(),
            ]);

            //Si tous se passe bien return True
            return [true,"Modification de votre commentaire effectué"];

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }

    }

    //Getters and Setters

    /**
     * @return Int
     */
    public function getIdInfo(): int
    {
        return $this->Id_info;
    }

    /**
     * @param Int $Id_info
     */
    public function setIdInfo(int $Id_info): void
    {
        $this->Id_info = $Id_info;
    }

    /**
     * @return Int
     */
    public function getIdMovie(): int
    {
        return $this->Id_movie;
    }

    /**
     * @param Int $Id_movie
     */
    public function setIdMovie(int $Id_movie): void
    {
        $this->Id_movie = $Id_movie;
    }

    /**
     * @return Int
     */
    public function getIdUser(): int
    {
        return $this->Id_user;
    }

    /**
     * @param Int $Id_user
     */
    public function setIdUser(int $Id_user): void
    {
        $this->Id_user = $Id_user;
    }

    /**
     * @return Float
     */
    public function getRate(): float
    {
        return $this->Rate;
    }

    /**
     * @param Float $Rate
     */
    public function setRate(float $Rate): void
    {
        $this->Rate = $Rate;
    }

    /**
     * @return String
     */
    public function getComment(): string
    {
        return $this->Comment;
    }

    /**
     * @param String $Comment
     */
    public function setComment(string $Comment): void
    {
        $this->Comment = $Comment;
    }

    /**
     * @return bool
     */
//    public function isShare(): bool
//    {
//        return $this->Share;
//    }
//
//    /**
//     * @param bool $Share
//     */
//    public function setShare(bool $Share): void
//    {
//        $this->Share = $Share;
//    }
//
//    /**
//     * @return bool
//     */
//    public function isSee(): bool
//    {
//        return $this->See;
//    }
//
//    /**
//     * @param bool $See
//     */
//    public function setSee(bool $See): void
//    {
//        $this->See = $See;
//    }
//
//    /**
//     * @return bool
//     */
//    public function isToSee(): bool
//    {
//        return $this->To_see;
//    }
//
//    /**
//     * @param bool $To_see
//     */
//    public function setToSee(bool $To_see): void
//    {
//        $this->To_see = $To_see;
//    }


}