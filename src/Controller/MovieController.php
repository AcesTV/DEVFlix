<?php


namespace src\Controller;

use src\Model\Movie;
use src\Model\BDD;

class MovieController extends AbstractController
{
    public function index(){


        if (isset($_SESSION["ID_USER"])){
            echo "Bienvenue sur l'accueil ${_SESSION["Pseudo"]}<br>";
            echo "<a href='/user/profil'>Accédez à mon profil</a><br>";
            echo "<a href='/user/logout'>Déconnexion</a>";
        } else {
            echo "Bienvenue sur l'accueil<br>";
            echo "<a href='/user/login'>Connexion</a>";
        }

    }

    public function List(){
        $movie = new Movie();
        $movieList = $movie->SqlGetAll(BDD::getInstance());

        return $this->twig->render("Movie/list.html.twig",[
            "movieList" => $movieList
        ]);
    }
}
