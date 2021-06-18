<?php

namespace src\Controller;

use src\Model\InfoMovie;
use src\Model\User;
use src\Model\BDD;

class InfoMovieController extends AbstractController
{
    public function index(){
        echo "Controller Infomovie";
        //rediriger vers index (Page d'accueil)
    }

    //Afficher la liste complète des commentaires
    public function List(){
        $VarUser = new User();

        if ($VarUser->CheckAdminUser()){
            $infoMovie = new InfoMovie();
            $infoMovieList = $infoMovie->SQLGetAll(BDD::getInstance());

            return $this->twig->render("InfoMovie/list.html.twig",[
                "infoMovieList" => $infoMovieList,
                "IsOnline" => isset($_SESSION["Pseudo"])
            ]);
        } else {
            header("location:/");
        }


    }

    //Fonction Ajout
    public function AddInfoMovie(){
        //Permet la vérification de la présence d'un ID pour le film
        if (!isset($_GET["param"]) OR empty($_GET["param"])){
            header("location:/");
        }

        if (isset($_POST["Rate"]) && isset($_POST["Comment"])){
            $val = new InfoMovie();
            $val->setRate($_POST["Rate"] > 10 ? 10 : $_POST["Rate"]);
            $val->setComment($_POST["Comment"]);

            //Retourne TRUE si l'utilisateur a déjà posté un commentaire pour le film
            $response = $val->SQLGetCommentUserMovie(BDD::getInstance(),$_GET["param"]);

            if ($response[0]){
                $response = $val->SQLUpdateInfoMovie(BDD::getInstance(),$response[1][0]);
            } else {
                $response = $val->SQLAddInfoMovie(BDD::getInstance());
            }

            if ($response[0]) {
                header("location:/movie/${_GET["param"]}");
            } else {
                echo "Une erreur s'est produite : ${response}";
            }
        } else {
            //Affiche la vue
            return $this->twig->render("InfoMovie/AddInfoMovie.html.twig",[
                "ID_MOVIE" => $_GET["param"],
                "IsOnline" => isset($_SESSION["Pseudo"])
            ]);
        }



    }

    //Fonction Modifier
    public function UpdateInfoMovie($id){
        //Permet la vérification de la présence d'un ID pour le commentaire et l'id de l'utilisateur
        $admin = new User();
        if (!isset($_GET["param"]) OR empty($_GET["param"]) OR !isset($_SESSION["ID_USER"])){
            header("location:/");
        }

        $movie = new InfoMovie();
        if(isset($_POST["Comment"]) && isset($_POST["Rate"])) {
            $movie->setComment($_POST["Comment"]);
            $movie->setRate($_POST["Rate"]);


            $response = $movie->SQLUpdateInfoMovie(BDD::getInstance(), $id);
            if ($response[0]){
                header("location:/movie/${_POST["ID_MOVIE"]}");
            } else {
                echo "Une erreur s'est produite : ${response[1]}";
            }
        } else {
            $movieInfo = $movie->SQLGetOne(BDD::getInstance(), $id);

            if (($_SESSION["ID_USER"] != $movieInfo["ID_USER"]) AND $admin->CheckAdminUser() == false) {
                header("location:/movie/${movieInfo["ID_MOVIE"]}");
            }

            return $this->twig->render("InfoMovie/UpdateInfoMovie.html.twig",[
                "InfoMovie" => $movieInfo,
                "IsOnline" => isset($_SESSION["Pseudo"])
            ]);
        }
    }

    //Fonction pour supprimer une note et le commentaire d'un utilisateur
    public function BtnDeleteInfoMovie($id){
        //Permet la vérification de la présence d'un ID pour le commentaire
        if (!isset($id) OR empty($id)){
            header("location:/");
        }

        $InfoMovie = new InfoMovie();
        $admin = new User();
        $pre_reponse = $InfoMovie->SQLGetOne(BDD::getInstance(), $id);

        if (($admin->CheckAdminUser() OR $_SESSION["ID_USER"] == $pre_reponse["ID_USER"]) AND $pre_reponse != false){

            if (($pre_reponse["SHARE"] == 1) OR ($pre_reponse["TO_SEE"] == 1)){
                $InfoMovie->setComment("");
                $InfoMovie->setRate(-1);
                $response = $InfoMovie->SQLUpdateInfoMovie(BDD::getInstance(), $id);
            } else {
                $response = $InfoMovie->SQLDeleteInfoMovie(BDD::getInstance(), $id);
            }

            if ($response[0]){
                header("Location:/movie/${pre_reponse["ID_MOVIE"]}");

            } else {
                echo "Une erreur s'est produite : ${response[1]}";
            }

        } else {
            header("location:/}");

        }

    }

    //Permet de lancer la requete qui change le status de 'ToSee' dans la bdd
    public function BtnToSee($id){
        if (isset($_SESSION["ID_USER"])){
            $val = new InfoMovie();
            $response = $val->SQLToSee(BDD::getInstance(),$_GET["param"]);

            if ($response[0]) {
                header("location:/movie/${_GET["param"]}");
            } else {
                header("location:/");
            }

        } else {
            header("location:/");
        }

    }

    //Permet la modification du partage
    public function BtnToShare($id){
        if (isset($_SESSION["ID_USER"])){
            $val = new InfoMovie();
            $response = $val->SQLToShare(BDD::getInstance(),$_GET["param"]);

            if ($response[0]) {
                header("location:/movie/${_GET["param"]}");
            } else {
                header("location:/");
            }

        } else {
            header("location:/");
        }

    }

    //Permet la modification du partage
    public function BtnAskShare($id){
        //ToDo : Empecher les multiples demandes sur un même film
        //ToDo : Vérifier que les dates sont logique (Date debut < Date fin)

        if (isset($_SESSION["ID_USER"])){
            $val = new InfoMovie();
            $response = $val->SQLAskShare(BDD::getInstance(),$_GET["param"]);

            if ($response[0]) {
                header("location:/movie/${_GET["param"]}");
            } else {
                header("location:/");
            }

        } else {
            header("location:/");
        }

    }

}