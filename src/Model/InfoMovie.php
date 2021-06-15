<?php
namespace src\Model;

//use Twig\Extension\StringLoaderExtension;

class InfoMovie
{
    private Int $Id_info;
    private Int $Id_movie;
    private Int $Id_user;
    private Float $Rate;
    private String $Comment;
    private int $Share;
    private bool $To_see;

    //Fonction afficher un commentaire
    public function SQLGetOne(\PDO $bdd, $id) {
        $requete = $bdd->prepare("SELECT * FROM t_info_movies WHERE ID_INFO=:ID");
        $requete->execute([
            "ID" => $id
        ]);
        return $requete->fetch();
    }

    //Fonction afficher tous les commentaires
    public function SQLGetAll(\PDO $bdd) {
        $requete = $bdd->prepare("SELECT * FROM t_info_movies INNER JOIN t_users ON t_info_movies.ID_USER = t_users.ID_USER INNER JOIN t_movies on t_info_movies.ID_MOVIE = t_movies.ID_MOVIE WHERE RATE IS NOT NULL");
        $requete->execute();
        return $requete->fetchAll(\PDO::FETCH_CLASS, "src\Model\InfoMovie");
    }

    //Fonction afficher les commentaires d'un film
    public function SQLGetCommentMovie(\PDO $bdd, $id) : array {
        $requete = $bdd->prepare("SELECT * FROM t_info_movies WHERE ID_MOVIE=:ID AND RATE IS NOT NULL");
        $requete->execute([
            "ID" => $id
        ]);
        return [true, $requete->fetchAll()];
    }

    //Fonction afficher les commentaires d'un utilisateur
    public function SQLGetCommentUser(\PDO $bdd, $id) : array {
        $requete = $bdd->prepare("SELECT ID_INFO,t_info_movies.ID_MOVIE,COMMENT,RATE,NAME FROM t_info_movies INNER JOIN t_movies ON t_info_movies.ID_MOVIE = t_movies.ID_MOVIE WHERE ID_USER=:ID");
        $requete->execute([
            "ID" => $id
        ]);
        return [true, $requete->fetchAll()];
    }

    //Fonction vérifier si un utilisateur à déjà une ligne pour le film demandé
    public function SQLGetCommentUserMovie(\PDO $bdd, $id) : array {
        $requete = $bdd->prepare("SELECT ID_INFO,SHARE,TO_SEE FROM t_info_movies WHERE ID_USER=:ID_USER AND ID_MOVIE=:ID_MOVIE");
        $response = $requete->execute([
            "ID_MOVIE" => $id,
            "ID_USER" => $_SESSION["ID_USER"] ?? null
        ]);

        if ($response == false) {
            return [false, "Non"];
        } else {
            return [true, $requete->fetch()];
        }

    }

    //Fonction SQLAjout
    public function SQLAddInfoMovie(\PDO $bdd) : array{

        try{
            $requete = $bdd->prepare("INSERT INTO t_info_movies (ID_MOVIE, ID_USER, RATE, COMMENT) VALUES(:ID_MOVIE, :ID_USER, :RATE, :COMMENT)");
            $requete->execute([
                "ID_MOVIE" => $_GET["param"],
                "ID_USER" => $_SESSION["ID_USER"],
                "RATE" => $this->getRate(),
                "COMMENT" => $this->getComment()
            ]);

            //Si tous se passe bien return True
            return [true,"Ajout de votre commentaire effectué"];

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }
    }

    //Fonction SQLUpDadeInfoMovie
    public function SQLUpdateInfoMovie(\PDO $bdd, $id) : array{

        try{
            $requete = $bdd->prepare("UPDATE t_info_movies SET RATE=:RATE, COMMENT=:COMMENT WHERE ID_INFO=:ID");
            $requete->execute([
                "ID" => $id,
                "RATE" => $this->getRate() == -1 ? null : $this->getRate(),
                "COMMENT" => $this->getComment() == '' ? null : $this->getComment()
            ]);

            //Si tous se passe bien return True
            return [true,"Modification de votre commentaire effectué"];

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }
    }

    //Fonction de suppression de TOUTES les informations dans la table info movie via un ID
    public function SQLDeleteInfoMovie(\PDO $bdd, $id) : array{
        try{
            //Récupération de L'ID_Info
            $requete = $bdd->prepare("DELETE FROM t_info_movies WHERE ID_INFO=:ID");
            $requete->execute([
                "ID" => $id
            ]);
            return [true,'Suppression réalisée avec succès'];

        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Modifier le status de TO_SEE
    public function SQLToSee(\PDO $bdd, $id) : array{
        $response = $this->SQLGetCommentUserMovie(BDD::getInstance(),$id);

        if ($response[1]) {
            $requete = $bdd->prepare("UPDATE t_info_movies SET TO_SEE=:TO_SEE WHERE ID_USER=:ID_USER AND ID_MOVIE=:ID_MOVIE");
            $requete->execute([
                "ID_USER" => $_SESSION["ID_USER"],
                "ID_MOVIE" => $id,
                "TO_SEE" => $response[1][2] == true ? 0 : 1
            ]);
        } else {
            $requete = $bdd->prepare("INSERT INTO t_info_movies (ID_MOVIE, ID_USER, TO_SEE) VALUES (:ID_MOVIE,:ID_USER,:TO_SEE)");
            $requete->execute([
                "ID_USER" => $_SESSION["ID_USER"],
                "ID_MOVIE" => $id,
                "TO_SEE" => 1
            ]);
        }

        return[true,"OK"];
    }

    //Modifier le status de SHARE
    public function SQLToShare(\PDO $bdd, $id) : array
    {
        $response = $this->SQLGetCommentUserMovie(BDD::getInstance(), $id);
        if ($response[1]) {
            $requete = $bdd->prepare("UPDATE t_info_movies SET SHARE=:SHARE WHERE ID_USER=:ID_USER AND ID_MOVIE=:ID_MOVIE");
            $requete->execute([
                "ID_USER" => $_SESSION["ID_USER"],
                "ID_MOVIE" => $id,
                "SHARE" => $response[1][1] == 1 ? 0 : 1
            ]);
        } else {
            $requete = $bdd->prepare("INSERT INTO t_info_movies (ID_MOVIE, ID_USER, SHARE) VALUES (:ID_MOVIE,:ID_USER,:SHARE)");
            $requete->execute([
                "ID_USER" => $_SESSION["ID_USER"],
                "ID_MOVIE" => $id,
                "SHARE" => 1
            ]);
        }

        return [true, "OK"];
    }

    //Modifier le status de SHARE
    public function SQLAskShare(\PDO $bdd, $id) : array
    {
        try{
            $requete = $bdd->prepare("INSERT INTO t_prets (ID_USER, ID_MOVIE, DATE_PRET, DATE_RETOUR) VALUES (:ID_USER, :ID_MOVIE, :DATE_PRET, :DATE_RETOUR)");
            $requete->execute([
                "ID_USER" => $_SESSION["ID_USER"],
                "ID_MOVIE" => $id,
                "DATE_PRET" => htmlspecialchars($_POST["DateDebut"]),
                "DATE_RETOUR" => htmlspecialchars($_POST["DateFin"])
            ]);

            return [true, "OK"];

        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Afficher les films que l'on peux preter
    public function SQLSelectMovieCanShare(\PDO $bdd, $id) : array
    {
        try{
            $requete = $bdd->prepare("SELECT t_prets.ID_PRET,t_prets.DATE_PRET,t_prets.DATE_RETOUR,t_movies.NAME,t_users.PSEUDO FROM t_prets INNER JOIN t_movies ON t_prets.ID_MOVIE = t_movies.ID_MOVIE INNER JOIN t_users ON t_prets.ID_USER = t_users.ID_USER WHERE t_prets.APPROVE = 0 AND t_prets.ID_MOVIE IN (SELECT ID_MOVIE FROM t_info_movies WHERE SHARE = 1 AND ID_USER = :ID_USER)");
            $requete->execute([
                "ID_USER" => $id
            ]);

            $data = $requete->fetchAll();

            return [true, $data];

        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Fonction qui permet d'accepter une demande de pret
    //ToDo : Vérifier que l'on peux bien accepter car on l'a et pas déjà preter !  !
    public function SQLUpdateAcceptPret(\PDO $bdd, $id) : array{
        try{
            $requete = $bdd->prepare("UPDATE t_prets SET ID_USER_PRET=:ID_USER_PRET,APPROVE = 1 WHERE ID_PRET=:ID_PRET");
            $requete->execute([
                "ID_USER_PRET" => $_SESSION["ID_USER"],
                "ID_PRET" => $id
            ]);

            return[true,"Ok"];

        } catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Fonction SQL qui permet de recupérer les demandes de prêts perso en attente
    public function SQLGetMoviePretToSee(\PDO $bdd, $id): array{
        try{
            $requete = $bdd->prepare("SELECT T_MOVIES.NAME,T_PRETS.ID_PRET,T_PRETS.DATE_PRET,T_PRETS.DATE_RETOUR FROM t_movies INNER JOIN t_prets ON t_movies.ID_MOVIE = t_prets.ID_MOVIE WHERE t_prets.ID_USER = :ID_USER AND APPROVE = 0");
            $requete->execute([
                "ID_USER" => $id
            ]);

            $data = $requete->fetchAll();

            return [true,$data];

        } catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Fonction qui permet d'obtenir l'ID utilisateur via un ID de prêt
    public function SQLGetOnePret(\PDO $bdd, $id){
        try{
            $requete = $bdd->prepare("SELECT ID_USER FROM t_prets WHERE ID_PRET=:ID_PRET");
            $requete->execute([
                "ID_PRET" => $id
            ]);

            return [true,$requete->fetch()];

        } catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Fonction qui permet de supprimer un pret
    public function SQLDeleteMoviePretToSee(\PDO $bdd, $id): array{
        try{
            $ValUser = New User();

            $pre_response = $this->SQLGetOnePret(BDD::getInstance(),$id);
            if ($pre_response[1]["ID_USER"] == $_SESSION["ID_USER"] OR $ValUser->CheckAdminUser()){
                $requete = $bdd->prepare("DELETE FROM t_prets WHERE ID_PRET=:ID_PRET");
                $requete->execute([
                    "ID_PRET" => $id
                ]);

                return [true,"Suppression OK"];
            } else {
                return[false,"Vous n'êtes pas autorisé à effectuer cette action !"];
            }

        } catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
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
    public function isShare(): bool
    {
        return $this->Share;
    }

    /**
     * @param bool $Share
     */
    public function setShare(bool $Share): void
    {
        $this->Share = $Share;
    }

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
    /**
     * @return bool
     */
    public function isToSee(): bool
    {
        return $this->To_see;
    }

    /**
     * @param bool $To_see
     */
    public function setToSee(bool $To_see): void
    {
        $this->To_see = $To_see;
    }
}