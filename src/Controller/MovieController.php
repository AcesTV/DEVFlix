<?php


namespace src\Controller;

use src\Model\Movie;
use src\Model\BDD;

class MovieController extends AbstractController
{
    public function index(){

        echo "Accueil du site WEB";
    }

    public function List(){
        $movie = new Movie();
        $movieList = $movie->SqlGetAll(BDD::getInstance());

        return $this->twig->render("Movie/list.html.twig",[
            "movieList" => $movieList
        ]);
    }
}
