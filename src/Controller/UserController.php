<?php


namespace src\Controller;

use src\Model\User;
use src\Model\BDD;
use Twig\Error\LoaderError;

class UserController extends AbstractController
{
    public function index(){
        echo "Controller User";
        //rediriger vers index (Page d'accueil)
    }

    //Fonction Ajout
    public function AddUser(){

        if (isset($_POST["Email"]) && isset($_POST["Pseudo"]) && isset($_POST["Password"])){

            if(empty($_POST["Email"]) || empty($_POST["Pseudo"]) || empty($_POST["Password"])){
                try {
                    //TODO Remplir les chanmps si rempli
                    //TODO Ajouter la vérification mot de passe sont les mêmes
                    //TODO Ajouter la vérification adresse mail sont les mêmes
                    echo $this->twig->render("AddUser.html.twig", [
                        "Pseudo" => $_POST["Pseudo"],
                        "Email" => $_POST["Email"]
                    ]);

                    echo "Veuillez remplir tous les champs";


                } catch (LoaderError $e) {
                    echo $e->getMessage();
                }

            } else {

                $val = new User();
                $val->setUserPSEUDO($_POST["Pseudo"]);
                $val->setUserPASSWORD(password_hash($_POST["Password"], PASSWORD_BCRYPT, ["cost" => 10]));
                $val->setUserMAIL($_POST["Email"]);

                $response = $val->SQLAddUser(BDD::getInstance());
                if ($response == true){
                    echo "Inscription réussi";

                } else {
                    echo "Une erreur c'est produite : ${response}";
                }
            }

        } else {
            //Affiche la vue
            try {
                echo $this->twig->render("AddUser.html.twig", []);
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        }

    }

    //Fonction Modifier
    public function LoginUser(){
        if (isset($_POST["Pseudo"])){
            //Si un Email est renseigné
            $val = new User();
            $val->setUserPSEUDO($_POST["Pseudo"]);
            $val->setUserPASSWORD($_POST["Password"]);

            $response = $val->SQLLoginUser(BDD::getInstance());
            if ($response[0] == true){
                echo $response[1];

            } else {
                echo "Une erreur c'est produite : ${response[1]}";
            }

        } else {
            //Affiche la vue
            try {
                echo $this->twig->render("Login.html.twig", []);
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        }
    }

    //Fonction Modifier
    public function ModifyUser(){
        if (isset($_POST["Pseudo"])){
            //Si un Email est renseigné
            $val = new User();
            $val->setUserPSEUDO($_POST["Pseudo"]);
            $val->setUserPASSWORD($_POST["Password"]);

            $response = $val->SQLLoginUser(BDD::getInstance());
            if ($response[0] == true){
                echo $response[1];

            } else {
                echo "Une erreur c'est produite : ${response[1]}";
            }

        } else {
            //Affiche la vue
            try {
                echo $this->twig->render("Login.html.twig", []);
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
        echo "GetOne";
    }

    //Fonction GetAll
    public function GetAll(){
        echo "GetAll";
    }
}