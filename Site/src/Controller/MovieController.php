<?php

namespace src\Controller;

use src\Model\Movie;
use src\Model\InfoMovie;
use src\Model\BDD;
use src\Model\User;

class MovieController extends AbstractController
{

    public function index(){
        $movie = new Movie();
        $movieList = $movie->SQLGetAll(BDD::getInstance());

        return $this->twig->render("Movie/accueil.html.twig",[
            "movieList" => $movieList,
            "IsOnline" => isset($_SESSION["Pseudo"]),
            "IsAdmin" => (isset($_SESSION["IsAdmin"]) AND $_SESSION["IsAdmin"])
        ]);
    }

    public function List(){
        $movie = new Movie();
        $movieList = $movie->SQLGetAll(BDD::getInstance());

        return $this->twig->render("Movie/accueil.html.twig",[
            "movieList" => $movieList,
            "IsAdmin" => (isset($_SESSION["IsAdmin"]) AND $_SESSION["IsAdmin"])
        ]);
    }

    public function ListAdmin(){
        $admin = new User();
        if (!$admin->CheckAdminUser()){
            header("location:/");
        }

        $movie = new Movie();
        $movieList = $movie->SQLGetAll(BDD::getInstance());

        return $this->twig->render("Movie/list-admin.html.twig",[
            "movieList" => $movieList,
            "IsOnline" => isset($_SESSION["Pseudo"]),
            "IsAdmin" => (isset($_SESSION["IsAdmin"]) AND $_SESSION["IsAdmin"])
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


        $totalRate = 0;
        $totalRateVote = 0;
        if(!empty($response[1])){
            foreach ($response[1] as $key => $value) {
                $totalRate += $value['RATE'];
                $totalRateVote++;
            }
            $totalRate = round($totalRate / $totalRateVote,2);
        } else {
            $totalRate = "Non défini";
        }

        $response2 = $detailsmovie->SQLGetCommentUserMovie(BDD::getInstance(), $id);

        return $this->twig->render("Movie/list.html.twig",[
            "movie" => $movie,
            "infoMovieList" => $response[1],
            "Share" => $response2[0] ? $response2[1][1] : 0,
            "ToSee" => $response2[0] ? $response2[1][2] : 0,
            "totalRate" => $totalRate,
            "ID_SESSION" => $_SESSION["ID_USER"] ?? null,
            "IS_ADMIN" => $_SESSION["IsAdmin"] ?? null,
            "IsOnline" => isset($_SESSION["Pseudo"]),
            "IsAdmin" => (isset($_SESSION["IsAdmin"]) AND $_SESSION["IsAdmin"])
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
            return $this->twig->render("Movie/addMovie.html.twig",[
                "IsOnline" => isset($_SESSION["Pseudo"])
            ]);
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
                "movie" => $movie,
                "IsOnline" => isset($_SESSION["Pseudo"])
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
        header('location:/admin/movies');
    }

}
