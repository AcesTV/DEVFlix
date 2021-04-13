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

                    echo $this->twig->render("User/AddUser.html.twig", [
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
                if ($response[0] == true){
                    echo "Inscription réussi";

                } else {
                    echo "Une erreur c'est produite : ${response[1]}";
                }
            }

        } else {
            //Affiche la vue
            try {
                echo $this->twig->render("User/AddUser.html.twig", []);
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        }

    }

    //Fonction Login
    public function LoginUser(){
        //Todo Récupérer si l'utilisateur est un admin

        if (isset($_POST["Pseudo"])){
            //Si tentative de connexion
            $val = new User();
            $val->setUserPSEUDO($_POST["Pseudo"]);
            $val->setUserPASSWORD($_POST["Password"]);

            $response = $val->SQLLoginUser(BDD::getInstance());
            if ($response[0] == true){
                echo $response[1];
                $_SESSION["Pseudo"] = $val->getUserPSEUDO();
                $_SESSION["IsAdmin"] = $val->getUserISADMIN();

            } else {
                echo "Une erreur c'est produite : ${response[1]}";
            }

        } elseif(isset($_SESSION["Pseudo"]) && empty($_SESSION["Pseudo"]) == false) {
            //Si déjà connecté alors on envoi vers l'accueil
            try {
                echo $this->twig->render("base.html.twig", []);
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        } else {
            //Si pas connecté
            try {
                if (isset($_GET["param"]) && ($_GET["param"] == "loginneed")){
                    echo "<p>Vous devez être connectez pour pourvour modifier votre profil</p>";
                }
                echo $this->twig->render("User/LoginUser.html.twig", []);
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        }
    }

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

    //Fonction ModifyAdmin
    public function ModifyAdmin(){
        //Si l'utilisateur à déjà un rôle le modifier sinon sinon le créer
        if (isset($_SESSION["IsAdmin"]) && ($_SESSION["IsAdmin"]) == true){
            $val = new User();


            /*
             * Valeur à récup pour que cela fonctionne !
             *
             * $val->setUserNOMROLE("");
             * $val->setUserISADMIN(false);
             * $val->setUserPSEUDO("Paulin2");
             * $val->setUserID("23");
            */


            if ($val->getUserISADMIN() == true){
                $checked = "checked";
            } else {
                $checked = "";
            }

            echo $this->twig->render("UserAdmin/ModifyUserAdmin.html.twig", [
                "ischeck" => $checked,
                "Pseudo" => $val->getUserPSEUDO()
            ]);

            if (isset($_POST["Role"]) and empty($_POST["Role"]) == false){
                $val->setUserISADMIN(true);
                $val->setUserNOMROLE("Admin");
            } else {
                $val->setUserISADMIN(false);
            }

            $response = $val->SQLModifyAdmin(BDD::getInstance());

            if ($response[0] == true) {
                echo $response[1];

            } else {
                echo $this->twig->render("User/ModifyUserAdmin.html.twig", [
                    "ischeck" => $checked,
                    "Pseudo" => $val->getUserPSEUDO()
                ]);
                echo "Une erreur c'est produite : ${response[1]}";
            }

        } else {
            echo "ACCES DENIED - Vous n'êtes pas admin";
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