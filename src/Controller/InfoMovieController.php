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
        $infoMovie = new InfoMovie();
        $infoMovieList = $infoMovie->SQLGetAll(BDD::getInstance());

        return $this->twig->render("InfoMovie/list.html.twig",[
            "infoMovieList" => $infoMovieList
        ]);
    }

    //Fonction GetOne
    public function GetOne(){
        if (isset($_POST["Pseudo"]) || (isset($_GET["param"]) == true && empty($_GET["param"]) == false)){
            try {
                $pseudo = isset($_POST["Pseudo"]) ? $_POST["Pseudo"] : $_GET["param"];
                $val = new User();
                $val->setUserPSEUDO($pseudo);

                $response = $val->SQLGetOne(BDD::getInstance());

                if ($response[0]) {
                    var_dump($response[1]);
                } else {
                    echo "Une erreur c'est produite : ${response[1]}";
                }
            } catch(\Exception $e) {
                echo $this->twig->render("User/test.html.twig", []);
                echo $e->getMessage();
            }
        } else {
            echo $this->twig->render("User/test.html.twig", []);
        }
    }

    //Fonction Ajout
    public function AddInfoMovie(){
        //ToDo : Vérifier si pas déjà un commentaire pour l'ID si existe, renvoyer sur la modification
        //Permet la vérification de la présence d'un ID pour le film
        if (!isset($_GET["param"]) OR empty($_GET["param"])){
            header("location:/");
        }

        if (isset($_POST["Rate"]) && isset($_POST["Comment"])){
            $val = new InfoMovie();
            $val->setRate($_POST["Rate"] > 10 ? 10 : $_POST["Rate"]);
            $val->setComment($_POST["Comment"]);
            $val->setShare(isset($_POST["Share"]));
            $val->setToSee(isset($_POST["To_See"]));

            $response = $val->SQLAddInfoMovie(BDD::getInstance());
            if ($response[0]) {
                header("location:/movie/${_GET["param"]}");
            } else {
                echo "Une erreur s'est produite : ${response}";
            }
        } else {
            //Affiche la vue
            return $this->twig->render("InfoMovie/AddInfoMovie.html.twig",[
                "ID_MOVIE" => $_GET["param"]
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
            $checkbox = isset($_POST["Share"])?1:0;
            $checkboxToSee = isset($_POST["To_See"])?1:0;
            $movie->setComment($_POST["Comment"]);
            $movie->setRate($_POST["Rate"]);
            $movie->setShare($checkbox);
            $movie->setToSee($checkboxToSee);

            $response = $movie->SQLUpdateInfoMovie(BDD::getInstance(), $id);
            if ($response[0]){
                header("location:/movie/${_POST["ID_MOVIE"]}");
            } else {
                echo "Une erreur s'est produite : ${response[1]}";
            }
        } else {
            $movieInfo = $movie->SQLGetOne(BDD::getInstance(), $id);

            if (($_SESSION["ID_USER"] != $movieInfo["ID_USER"]) OR $admin->CheckAdminUser() == false) {
                header("location:/movie/${movie["ID_MOVIE"]}");
            }

            return $this->twig->render("InfoMovie/UpdateInfoMovie.html.twig",[
                "InfoMovie" => $movieInfo
            ]);
        }
    }

    //Fonction Supprimer le commentaire
    public function DeleteInfoMovie($id){
        //Permet la vérification de la présence d'un ID pour le commentaire
        if (!isset($_GET["param"]) OR empty($_GET["param"])){
            header("location:/");
        }

        $InfoMovie = new InfoMovie();
        $admin = new User();
        $pre_reponse = $InfoMovie->SQLGetOne(BDD::getInstance(), $id);

        if (($pre_reponse["ID_USER"] != $_SESSION["ID_USER"]) OR $admin->CheckAdminUser() == false){
            header("location:/movie/${pre_reponse["ID_MOVIE"]}");
        }

        $response = $InfoMovie->SQLDeleteInfoMovie(BDD::getInstance(), $id);
        if ($response[0]){
            var_dump($_SERVER["HTTP_REFERER"]);
            header("Location: $_SERVER[HTTP_REFERER]");


        } else {
            echo "Une erreur s'est produite : ${response[1]}";
        }
    }


}