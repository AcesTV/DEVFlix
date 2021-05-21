<?php

namespace src\Controller;

use mysql_xdevapi\Exception;
use src\Model\User;
use src\Model\BDD;
use Twig\Error\LoaderError;

class UserController extends AbstractController
{
    //ToDo Couleur bouton formulaire

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
                echo '<script> alert("Les mots de passe ne correspondent pas !") </script>';
                exit();
            }

            //Vérifie si le mail est bien identiques
            if ($_POST["Email"] != $_POST["Emailcheck"]){
                echo '<script> alert("Les adresse mail ne correspond pas !") </script>';
                exit();

            }

            //Si toutes les vérifications sont OK
            $val->setUserPASSWORD(password_hash($_POST["Password"], PASSWORD_BCRYPT, ["cost" => 10]));
            $val->setUserMAIL($_POST["Email"]);

            $response = $val->SQLAddUser(BDD::getInstance());
            if ($response[0] == true){
                echo "Inscription réussi";

                //Paramètres du send mail
                $to_email= $val->getUserMAIL();
                $subject = "Bienvenue sur DevFlix !";
                $body = "<html>
                            <body>
                                <h1>Toutes l'équipe de DevFlix vous souhaite la bienvenue sur notre site !</h1>
                                Vous pouvez à présent commenter, noter et partager vos films préférés. <br><br>
                                Retrouvez nous vite sur notre site <a href='http://devflix.local'>DevFlix</a>
                            </body>
                        </html>";
                $headers = "From: devflix.cesi@gmail.com\r\n";
                $headers .= "MINE-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=utf-8\r\n";

                //Envoi du mail de bienvenue
                $this->sendmail($to_email, $subject, $body, $headers);

                header("location:/");

            } else if($response[1] == "PSEUDO_DOUBLON"){
                try {
                    echo $this->twig->render("User/AddUser.html.twig", [
                        "Email" => $_POST["Email"]
                    ]);
                } catch (LoaderError $e) {
                    echo $e->getMessage();
                }

                echo '<script > alert("le nom d\'utilisateur est déjà utilisé") </script>';

            } else if($response[1] == "MAIL_DOUBLON"){
                try {
                    echo $this->twig->render("User/AddUser.html.twig", [
                        "Pseudo"=> $_POST["Pseudo"]
                    ]);
                } catch (LoaderError $e) {
                    echo $e->getMessage();
                }
                echo '<script > alert("L\'email est déjà utilisée") </script>';

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
                echo $this->twig->render("User/AddUser.html.twig", []);

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
                $_SESSION["Pseudo"] = $val->getUserPSEUDO();
                $_SESSION["IsAdmin"] = $val->getUserISADMIN();
                $_SESSION["ID_USER"] = $val->getUserID();
                header("location:/");
            } else {
                echo "Une erreur c'est produite : ${response[1]}";
            }

        } elseif(isset($_SESSION["Pseudo"]) && empty($_SESSION["Pseudo"]) == false) {
            //Si l'utilisateur est déjà connecté, on le renvoi vers l'accueil
            try {
                //echo $this->twig->render("base-admin.html.twig", []);
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

    //Fonction Modifier du côté utilisateur
    public function ModifyUser(){
        //Todo : Ajouter l'interface des commentaire + possibilité de modifier et supprimer
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

    //Fonction ModifyAdmin qui permet la modification de l'email et du rôle côté admin
    public function ModifyAdmin(){
        $val = new User();
        if ($val->CheckAdminUser() == false){
            header("location:/login");
        }

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
                        echo "<h1><div class='msgerror'>Impossible de modifier le compte, vous êtes connecté à ce compte ! <a href='/admin/list'>Cliquez ici pour retourner à la liste</a></div></h1>";
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

    //Fonction Supprimer un utilisateur
    public function DeleteAdmin(){
        $val = new User();
        if ($val->CheckAdminUser() == false){
            header("location:/login");
        }

        if (isset($_GET["param"]) == false) {
            //Si il n'y a pas le paramètre ID_USER, on redirige vers la liste des utilisateurs
            header("location:/admin/list");
            exit();
        } else {
            $param = (isset($_GET["param"])) ? $_GET["param"] : "";

            $val = new User();
            $val->setUserID($param);
            $result = $val->SQLGetOne(BDD::getInstance());

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
                        echo "<h1><div class='msgerror'>Impossible de supprimer le compte, vous êtes connecté à ce compte ! <a href='/admin/list'>Cliquez ici pour retourner à la liste</a></div></h1>";
                    } else {

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
        $val = new User();
        if ($val->CheckAdminUser() == false){
            header("location:/login");
        }

             try {
                 $response = $val->SQLGetAll(BDD::getInstance());

                if ($response[0]) {
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

    //Fonction Reset Password
    public function ResetPassword(){
        //Vérification de déjà connecter
        if (isset($_SESSION['Pseudo'])) { header("location:/");}

        $val = new User();
        if (isset($_SESSION["RecoveryID"]) AND !empty($_SESSION["RecoveryID"])){ $val->setRecoveryID($_SESSION["RecoveryID"]);}

        //Interface Niveau 4
        if (isset($_POST["Password"]) AND !empty($_POST["Password"]) AND isset($_POST["PasswordCheck"]) AND !empty($_POST["PasswordCheck"])){
            //Si les mot de passe son identique alors on le met à jour
            if ($_POST["Password"] == $_POST["PasswordCheck"]){
                $val->setRecoveryPassword(password_hash($_POST["Password"], PASSWORD_BCRYPT, ["cost" => 10]));
                $val->SQLUpdatePassword(BDD::getInstance());

                //Destruction de la variable de session RecoveryID
                unset($_SESSION["RecoveryID"]);

                return $this->twig->render("User/reset.html.twig",[
                    "ValeurBouton" => "Valider le nouveau mot de passe",
                    "NiveauInterface" => 0,
                    "MSG_SUCCES" => "Modification du mot de passe réussit"
                ]);


            } else {
                return $this->twig->render("User/reset.html.twig",[
                    "ValeurBouton" => "Valider le nouveau mot de passe",
                    "NiveauInterface" => 2,
                    "RecoveryEmail" => $_POST["Email"],
                    "MSG_ERR" => "Les mots de passe ne sont pas identiques"
                ]);
            }



            //Interface Niveau 3
        } elseif (isset($_POST["CleRecovery"]) AND !empty($_POST["CleRecovery"])){
            $val->setRecoveryCle($_POST["CleRecovery"]);
            $val->setRecoveryEmail($_POST["Email"]);

            $response = $val->SQLCheckCle(BDD::getInstance());

            if ($response[0]){
                return $this->twig->render("User/reset.html.twig",[
                    "ValeurBouton" => "Valider le nouveau mot de passe",
                    "NiveauInterface" => 2,
                    "RecoveryCleHidden" => $_POST["CleRecovery"],
                    "RecoveryEmail" => $_POST["Email"]
                ]);
            } else {
                return $this->twig->render("User/reset.html.twig",[
                    "ValeurBouton" => "Valider le mot de passe temporaire",
                    "NiveauInterface" => 1,
                    "MSG_ERR" => "Clé incorrecte !",
                    "RecoveryEmail" => $_POST["Email"]
                ]);
            }



            //Interface Niveau 2
        } elseif (isset($_POST["Email"]) AND !empty($_POST["Email"])){
            $val->setRecoveryEmail($_POST["Email"]);
            $response = $val->SQLCheckEmail(BDD::getInstance());

            if ($response[0]){

                $objet = "Récupération de votre mot de passe";
                $msg = htmlspecialchars("Voici votre mot de passe temporaire : " . $val->getRecoveryCle());
                $msg =  utf8_decode($msg) ;

                $to = $val->getRecoveryEmail();

                $headers = "From: Webmaster Site <webmaster@devflix.local>\n";
                $headers = $headers."Content-type: text/plain; charset=iso-8859-1\n";

                $this->sendmail($to, $objet, $msg, $headers);


                return $this->twig->render("User/reset.html.twig",[
                    "ValeurBouton" => "Valider le mot de passe temporaire",
                    "RecoveryEmail" => $val->getRecoveryEmail(),
                    "NiveauInterface" => 1
                ]);

            } else {
                return $this->twig->render("User/reset.html.twig",[
                    "ValeurBouton" => "Valider l'adresse email",
                    "NiveauInterface" => 0,
                    "MSG_ERR" => "L'adresse email n'est pas présente dans notre base"
                ]);
            }

            //Interface Niveau 1
        } else {
            $val->setRecoveryID("12");
            return $this->twig->render("User/reset.html.twig",[
                "ValeurBouton" => "Valider l'adresse email",
                "NiveauInterface" => 0
            ]);
        }
    }

    //Fonction d'envoi de mail
    public function sendmail(string $to_email, $subject, $body, $headers){
        mail($to_email, $subject, $body, $headers);

    }


}