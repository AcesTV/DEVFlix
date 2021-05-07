<?php

namespace src\Controller;

use src\Model\InfoMovie;
use src\Model\BDD;
//use Twig\Error\LoaderError;

class InfoMovieController extends AbstractController
{
    public function index(){
        echo "Controller Infomovie";
        //rediriger vers index (Page d'accueil)
    }

    //Fonction Ajout
    public function AddInfoMovie(){

        if (isset($_POST["Rate"]) && isset($_POST["Comment"]) && isset($_POST["Share"]) && isset($_POST["To_See"])){
            $val = new InfoMovie();

            $val->setRate($_POST["Rate"]);
            $val->setComment($_POST["Comment"]);
            $val->setShare($_POST["Share"]);
            $val->setToSee($_POST["To_See"]);

            $response = $val->SQLAddInfoMovie(BDD::getInstance());
            if ($response[0] == true) {
                echo "$response[1]";
            } else {
                echo "Une erreur s'est produite : ${response}";
            }
        } else {
            //Affiche la vue
            return $this->twig->render("InfoMovie/AddInfoMovie.html.twig");
        }
    }


    //Fonction Modifier
    public function UpdateInfoMovie($id){
        $movie = new InfoMovie();
        if(isset($_POST["Comment"]) && isset($_POST["Rate"])) {
            $checkbox = isset($_POST["Share"])?1:0;
            $checkboxToSee = isset($_POST["To_See"])?1:0;
            $movie->setComment($_POST["Comment"]);
            $movie->setRate($_POST["Rate"]);
            $movie->setShare($checkbox);
            $movie->setToSee($checkboxToSee);

            $response = $movie->SQLUpdateInfoMovie(BDD::getInstance(), $id);
            if ($response[0] == true){
                echo "$response[1]";

            } else {
                echo "Une erreur s'est produite : ${response[1]}";
            }
        } else {
            $movie = $movie->SQLGetOne(BDD::getInstance(), $id);

            return $this->twig->render("InfoMovie/UpdateInfoMovie.html.twig",[
                "InfoMovie" => $movie
            ]);
        }
        header("Location: ?controller=InfoMovie&action=UpdateInfoMovie&param=$id");
    }

    //Fonction Supprimer
    public function DeleteUser(){
        echo "DeleteUser";
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

    //Fonction GetAll
    public function GetAll(){
        try {
            $val = new User();
            $response = $val->SQLGetAll(BDD::getInstance());

            if ($response[0]) {
                var_dump($response[1]);
            } else {
                echo "Une erreur c'est produite : ${response[1]}";
            }
        } catch(\Exception $e) {
            echo $this->twig->render("User/test.html.twig", []);
            echo $e->getMessage();
        }

    }
}