<?php

namespace src\Controller;

use src\Model\Movie;
use src\Model\InfoMovie;
use src\Model\BDD;
use src\Model\User;

class MovieController extends AbstractController
{

    public function index(){

        echo "Accueil du site WEB";
    }

    public function List(){
        $movie = new Movie();
        $movieList = $movie->SQLGetAll(BDD::getInstance());

        //ToDo : render la page d'accueil du site à implémenter
        return $this->twig->render("Movie/accueil.html.twig",[
            "movieList" => $movieList
        ]);
    }

    public function ListAdmin(){
        $admin = new User();
        if (!$admin->CheckAdminUser()){
            header("location:/");
        }

        $movie = new Movie();
        $movieList = $movie->SQLGetAll(BDD::getInstance());

        return $this->twig->render("Movie/list.html.twig",[
            "movieList" => $movieList
        ]);
    }

    public function ShowOneMovie(Int $id){
        $movie = new Movie();
        $movie = $movie->SQLGetOne(BDD::getInstance(), $id);

        if (!$movie){
            header("location:/");
        }

        $detailsmovie = new InfoMovie();
        $response = $detailsmovie->SQLGetCommentMovie(BDD::getInstance(), $id);

        return $this->twig->render("Movie/list.html.twig",[
            "movie" => $movie,
            "infoMovieList" => $response[1],
            "ID_SESSION" => isset($_SESSION["ID_USER"]) ? $_SESSION["ID_USER"] : null,
            "IS_ADMIN" => isset($_SESSION["IsAdmin"])
        ]);
    }

    public function AddMovie(){
        $admin = new User();
        if (!$admin->CheckAdminUser()){
            header("location:/");
        }

        if(isset($_POST["Name"]) && isset($_POST["Poster"]) && isset($_POST["Origin"]) && isset($_POST["VO"]) && isset($_POST["Actors"]) && isset($_POST["Director"]) && isset($_POST["Genre"]) && isset($_POST["ReleaseDate"]) && isset($_POST["Production"]) && isset($_POST["Runtime"]) && isset($_POST["Trailer"]) && isset($_POST["Nomination"]) && isset($_POST["Synopsis"])) {
            $checkbox = isset($_POST["DVD"]);
            $checkbox = ($checkbox == false) ? 0 : 1;
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
            $movie->setDvd($checkbox);

            $response = $movie->SQLAddMovie(BDD::getInstance());
            if ($response[0] == true){
                header("location:/admin/movies");

            } else {
                echo "Une erreur c'est produite : ${response}";
            }

        } else {
            return $this->twig->render("Movie/addMovie.html.twig");
        }

    }

    public function UpdateMovie($id){
        $admin = new User();
        if (!$admin->CheckAdminUser()){
            header("location:/");
        }

        $movie = new Movie();
        if(isset($_POST["Name"]) && isset($_POST["Poster"]) && isset($_POST["Origin"]) && isset($_POST["VO"]) && isset($_POST["Actors"]) && isset($_POST["Director"]) && isset($_POST["Genre"]) && isset($_POST["ReleaseDate"]) && isset($_POST["Production"]) && isset($_POST["Runtime"]) && isset($_POST["Trailer"]) && isset($_POST["Nomination"]) && isset($_POST["Synopsis"])) {
            $checkbox = isset($_POST["DVD"]);
            $checkbox = ($checkbox == false) ? 0 : 1;
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
            $movie->setDvd($checkbox);

            $response = $movie->SQLUpdateMovie(BDD::getInstance(), $id);
            if ($response[0] == true){
                echo "$response[1]";

            } else {
                echo "Une erreur c'est produite : ${response[1]}";
            }
        } else {
            $movie = $movie->SQLGetOne(BDD::getInstance(), $id);

            return $this->twig->render("Movie/updateMovie.html.twig",[
                "movie" => $movie
            ]);
        }
        header("Location:/admin/movie/modify/$id");
    }

    public function DeleteMovie($id){
        $admin = new User();
        if (!$admin->CheckAdminUser()){
            header("location:/");
        }

        $movie = new Movie();
        $response = $movie->SQLDeleteMovie(BDD::getInstance(), $id);
        if ($response[0] == true){
            echo "$response[1]";

        } else {
            echo "Une erreur c'est produite : ${response[1]}";
        }
        header('location:/admin/movie');
    }

}
