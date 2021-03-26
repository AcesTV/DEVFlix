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

    public function AddMovie(){

        if(isset($_POST["Name"]) && isset($_POST["Poster"]) && isset($_POST["Origin"]) && isset($_POST["VO"]) && isset($_POST["Actors"]) && isset($_POST["Director"]) && isset($_POST["Genre"]) && isset($_POST["ReleaseDate"]) && isset($_POST["Production"]) && isset($_POST["Runtime"]) && isset($_POST["Trailer"]) && isset($_POST["Nomination"]) && isset($_POST["Synopsis"]) && isset($_POST["DVD"])) {

            $movie = new Movie();

            $movie->setName($_POST["Name"]);
            $movie->setPoster($_POST["Poster"]);
            $movie->setOrigin($_POST["Origin"]);
            $movie->setVo($_POST["VO"]);
            $movie->setActors($_POST["Actors"]);
            $movie->setDirector($_POST["Director"]);
            $movie->setGenre($_POST["Genre"]);
            $movie->setReleaseDate($_POST["ReleaseDate"]);
            $movie->setProduction($_POST["Production"]);
            $movie->setRuntime($_POST["Runtime"]);
            $movie->setTrailer($_POST["Trailer"]);
            $movie->setNomination($_POST["Nomination"]);
            $movie->setSynopsis($_POST["Synopsis"]);
            $movie->setDvd($_POST["DVD"]);

            $response = $movie->SQLAddMovie(BDD::getInstance());
            if ($response[0] == true){
                echo "Inscription réussi";

            } else {
                echo "Une erreur c'est produite : ${response}";
            }

        } else {
            return $this->twig->render("Movie/addMovie.html.twig");
        }

    }

}
