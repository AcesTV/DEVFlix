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

        if (isset($_POST["Rate"]) && isset($_POST["Comment"])){

            if(empty($_POST["Rate"]) || empty($_POST["Comment"])){
                try {
                    //TODO Remplir les chanmps si rempli
                    //TODO Ajouter la vérification mot de passe sont les mêmes
                    //TODO Ajouter la vérification adresse mail sont les mêmes

                    echo $this->twig->render("InfoMovie/AddInfoMovie.html.twig", [
                        "Rate" => $_POST["Rate"],
                        "Comment" => $_POST["Comment"]
                    ]);

                    echo "Veuillez remplir tous les champs";


                } catch (LoaderError $e) {
                    echo $e->getMessage();
                }

            } else {

                $val = new InfoMovie();
                $val->setInfoMovieRATE($_POST["Rate"]);
                $val->setInfoMovieCOMMENT($_POST["Comment"]);


                $response = $val->SQLAddInfoMovie(BDD::getInstance());
                if ($response[0] == true){
                    echo "Commentaire ajouté";

                } else {
                    echo "Une erreur c'est produite : ${response[1]}";
                }
            }

        } else {
            //Affiche la vue
            try {
                echo $this->twig->render("InfoMovie/AddInfoMovie.html.twig", []);
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        }

    }
//    public function AddInfoMovie($id){
//        $movie = new InfoMovie();
//        if(isset($_POST["Rate"]) && isset($_POST["Comment"])) {
//            $movie->setRate($_POST["Rate"]);
//            $movie->setComment($_POST["Comment"]);
//
//            $response = $movie->SQLAddInfoMovie(BDD::getInstance(), $id);
//            if ($response[0] == true){
//                echo "$response[1]";
//
//            } else {
//                echo "Une erreur c'est produite : ${response[1]}";
//            }
//        }
//        header("Location: ?controller=InfoMovie&action=AddInfoMovie&param=$id");
//    }




    //Fonction Modifier
    public function ModifyUser(){

        //Si l'utilisateur est connecté et que le mot de passe ou l'email est renseigné
        if (empty($_SESSION["Pseudo"]) == false){

            if(isset($_POST["Password"]) || isset($_POST["Email"])) {
                $val = new User();

                $val->setUserPSEUDO($_SESSION["Pseudo"]);
                $val->setUserPASSWORD(password_hash($_POST["Password"], PASSWORD_BCRYPT, ["cost" => 10]));
                $val->setUserMAIL($_POST["Email"]);

                $response = $val->SQLModifyUser(BDD::getInstance());
                if ($response[0] == true) {
                    echo $response[1];

                } else {
                    echo $this->twig->render("User/ModifyUser.html.twig", []);
                    echo "Une erreur c'est produite : ${response[1]}";
                }

            } else {
                echo $this->twig->render("User/ModifyUser.html.twig", []);
            }


        } else {
            //Affiche la vue
            try {
                header("location:/?controller=User&action=LoginUser&param=loginneed");
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        }
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