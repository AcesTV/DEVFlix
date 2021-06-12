<?php


namespace src\Model;


class Pret
{


    //Fonction pour obtenir les informations d'un film
    public function SQLGetOne(\PDO $bdd, $id_movie) {
        $requete = $bdd->prepare("SELECT * FROM t_prets WHERE ID_MOVIE=:ID_MOVIE AND ID_USER=:ID_USER");
        $requete->execute([
            "ID_MOVIE" => $id_movie,
            "ID_USER" => $_SESSION["ID_USER"]
        ]);
        return $requete->fetch();
    }


}