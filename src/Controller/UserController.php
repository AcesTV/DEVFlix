<?php



namespace src\Controller;

use mysql_xdevapi\Exception;
use src\Model\User;
use src\Model\BDD;
use Twig\Error\LoaderError;

class UserController extends AbstractController
{
    public function index(){
        //En cas de problème, on redirige vers l'accueil
        header("location:/");
    }

    public function Admin(){
        header("location:/admin/list");
    }

    //Fonction Ajout
    public function AddUser(){
        //On vérifie si l'utilisateur est déjà connecté, si c'est le cas, on le redirige vers l'accueil
        if (isset($_SESSION["ID_USER"])){
            header("location:/");
        }

        //Si l'utilisateur à envoyer le formulaire
        if ((isset($_POST["Password"])) && isset($_POST["Email"])){
            //On défini le nom d'utilisateur et le mail
            $val = new User();
            $val->setUserPSEUDO($_POST["Pseudo"]);
            $val->setUserMAIL($_POST["Email"]);

            if ($_POST["Password"] != $_POST["Passwordcheck"]){
                echo '<script language="javascript"> alert("Les mots de passe ne correspondent pas !") </script>';
                exit();
            }

            //Vérifie si le mail est bien identiques
            if ($_POST["Email"] != $_POST["Emailcheck"]){
                echo '<script language="javascript"> alert("Les adresse mail ne correspond pas !") </script>';
                exit();

            }

            //Si toutes les vérifications sont OK
            $val->setUserPASSWORD(password_hash($_POST["Password"], PASSWORD_BCRYPT, ["cost" => 10]));
            $val->setUserMAIL($_POST["Email"]);

            $response = $val->SQLAddUser(BDD::getInstance());
            if ($response[0] == true){
                var_dump($_SESSION);
                echo "Inscription réussi";

                //ToDo envoyer mail de bienvenue, si le temps envoyer mail de confirmation

            } else if($response[1] == "PSEUDO_DOUBLON"){
                try {
                    echo $this->twig->render("User/AddUser.html.twig", [
                        "Email" => $_POST["Email"]
                    ]);
                } catch (LoaderError $e) {
                    echo $e->getMessage();
                }

                echo '<script language="javascript"> alert("le nom d\'utilisateur est déjà utilisé") </script>';


            } else if($response[1] == "MAIL_DOUBLON"){
                try {
                    echo $this->twig->render("User/AddUser.html.twig", [
                        "Pseudo"=> $_POST["Pseudo"]
                    ]);
                } catch (LoaderError $e) {
                    echo $e->getMessage();
                }

                echo '<script language="javascript"> alert("L\'email est déjà utilisée") </script>';


            } else {
                echo "Une erreur c'est produite : ${response[1]}";
                try {
                    echo $this->twig->render("User/AddUser.html.twig", [
                        "Pseudo"=> $_POST["Pseudo"]
                    ]);
                } catch (LoaderError $e) {
                    echo $e->getMessage();
                }
            }

        } else {
            try {
                echo $this->twig->render("User/AddUser.html.twig", [

                ]);
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        }

    }

    //Fonction Login
    public function LoginUser(){

        if (isset($_POST["Pseudo"])){
            //Si tentative de connexion
            $val = new User();
            $val->setUserPSEUDO($_POST["Pseudo"]);
            $val->setUserPASSWORD($_POST["Password"]);

            $response = $val->SQLLoginUser(BDD::getInstance());
            if ($response[0] == true){
                //echo $response[1];
                header("location:/");
                $_SESSION["Pseudo"] = $val->getUserPSEUDO();
                $_SESSION["IsAdmin"] = $val->getUserISADMIN();
                $_SESSION["ID_USER"] = $val->getUserID();

            } else {
                echo "Une erreur c'est produite : ${response[1]}";
            }


        } elseif(isset($_SESSION["Pseudo"]) && empty($_SESSION["Pseudo"]) == false) {
            //Si l'utilisateur est déjà connecté, on le renvoi vers l'accueil
            try {
                //echo $this->twig->render("base.html.twig", []);
                header("location:/");
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            //Si pas connecté
            try {
                echo $this->twig->render("User/LoginUser.html.twig", []);
            } catch (LoaderError $e) {
                echo $e->getMessage();
            }
        }
    }

    //Fonction de déconnexion
    public function LogoutUser(){
        if (empty($_SESSION["Pseudo"]) == false) {
            if (session_destroy()){
                header("location:/");
            } else {
                echo "<h1>Une erreur c'est produite lors de la déconnexion, veuillez réesayer</h1>";
            };
        } else {
            header("location:/");
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
                    if ($response[1]){
                        header("location:/user/profil");
                    }

                } else {
                    echo $this->twig->render("User/ModifyUser.html.twig", [
                        "Pseudo" => $_SESSION["Pseudo"]
                    ]);
                    echo "Une erreur c'est produite : ${response[1]}";
                }

            } else {
                echo $this->twig->render("User/ModifyUser.html.twig", [
                    "Pseudo" => $_SESSION["Pseudo"]
                ]);
            }


        } else {
            //Si utilisateur pas connecter alors on redirige
            header("location:/user/login");

        }
    }

    //Fonction ModifyAdmin
    public function ModifyAdmin(){
        $this->CheckAdminUser();

        if (isset($_GET["param"]) == false) {
            //Si il n'y a pas le paramètre ID_USER, on redirige vers la liste des utilisateurs
            header("location:/admin/list");
            exit();
        } else {
            $param = (isset($_GET["param"])) ? $_GET["param"] : "";

            $val = new User();
            $val->setUserID($param);
            $result = $val->SQLGetOne(BDD::getInstance());

            if ((isset($_GET["param"])) && (isset($_POST["ID_User"]))) {
                try {
                    $val->setUserMAIL($_POST["Email"]);
                    $isadmin = isset($_POST["Role"]);
                    $val->setUserISADMIN($isadmin);
                    $NameRole = empty($result[1]["NAME"]) ? "null" : "";
                    $val->setUserNOMROLE($NameRole);

                    $response = $val->SQLModifyAdmin(BDD::getInstance());

                    if ($response[0]) {
                        header("location:/admin/modify/${_GET["param"]}");
                    } else {
                        echo "Une erreur c'est produite : ${response[1]}";
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            } else if (isset($_GET["param"])) {
                if (($result[0] == false) || $result[1] == "No_Data") {
                    header("location:/admin/list");

                } else {
                    //On vérifie que le l'ID est différent de celui de la session

                    if ($param == $_SESSION["ID_USER"]) {
                        echo "<h1><font color='red'>Impossible de modifier le compte, vous êtes connecté à ce compte ! <a href='/admin/list'>Cliquez ici pour retourner à la liste</a></font></h1>";
                    } else {
                        $ischeck = (isset($_POST["Role"]) || $result[1]["ISADMIN"] == 1) ? "Checked" : "";

                        echo $this->twig->render("UserAdmin/ModifyAdmin.html.twig", [
                            "ID_User" => $result[1]["ID_USER"],
                            "Pseudo" => $result[1]["PSEUDO"],
                            "Email" => $result[1]["MAIL"],
                            "ischeck" => $ischeck
                        ]);
                    }
                }
            }
        }
    }

    //Fonction Supprimer
    public function DeleteAdmin(){
        $this->CheckAdminUser();

        if (isset($_GET["param"]) == false) {
            //Si il n'y a pas le paramètre ID_USER, on redirige vers la liste des utilisateurs
            header("location:/admin/list");
            exit();
        } else {
            $param = (isset($_GET["param"])) ? $_GET["param"] : "";

            $val = new User();
            $val->setUserID($param);
            $result = $val->SQLGetOne(BDD::getInstance());

            //

            if ((isset($_GET["param"])) && (isset($_POST["ID_User"]))){
                try {
                    $response = $val->SQLDeleteUser(BDD::getInstance());

                    if ($response[0]) {
                        header("location:/admin/list");
                    } else {
                        echo "Une erreur c'est produite : ${response[1]}";
                    }
                } catch(\Exception $e) {
                    echo $e->getMessage();
                }
            } else if(isset($_GET["param"])) {
                if (($result[0] == false) || $result[1] == "No_Data") {
                    header("location:/admin/list");

                } else {
                    //On vérifie que le l'ID est différent de celui de la session

                    if ($param == $_SESSION["ID_USER"]){
                        echo "<h1><font color='red'>Impossible de supprimer le compte, vous êtes connecté à ce compte ! <a href='/admin/list'>Cliquez ici pour retourner à la liste</a></font></h1>";
                    } else {
                        //ToDo Remplir la liste des différentes informations de l'utilisateur
                        echo $this->twig->render("UserAdmin/DeleteUser.html.twig", [
                            "Pseudo" => $result[1]["PSEUDO"],
                            "ID_User" => $result[1]["ID_USER"]
                        ]);
                    }


                }


            }
        }



    }

    //Fonction GetAll (Admin)
    public function GetAll(){
        $this->CheckAdminUser();
            try {
                $val = new User();
                $response = $val->SQLGetAll(BDD::getInstance());

                if ($response[0]) {
                    //var_dump($response[1]);
                    echo $this->twig->render("UserAdmin/ListUser.html.twig", [
                        "userslist" => $response[1]
                    ]);
                } else {
                    echo "Une erreur c'est produite : ${response[1]}";
                }

            } catch(\Exception $e) {
                echo $e->getMessage();
            }

    }

    //Fonction vérifie si admin
    public function CheckAdminUser(){

        if (isset($_SESSION["IsAdmin"]) == false || ($_SESSION["IsAdmin"] == false)){
            header("location:/user/login");
        }
    }

    //Fonction envoi de mail
    public function sendmail(){
        //Fonctionne avec la bonne configuration de xampp/Wamp !
        $to_email = "mrpaulin39@gmail.com";
        $subject = "Sujet du mail";
        $body = "Voici le message";
        $headers = "From: deflix.cesi@gmail.com";

        if (mail($to_email, $subject, $body, $headers)) {
            echo "Email envoyé avec succès à l'email : $to_email";
        } else {
            echo "L'envoi de l'email a échoué";
        }
    }


}