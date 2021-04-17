<?php


namespace src\Model;


class User
{
    //Variables
    private string $User_ID;
    private string $User_PSEUDO;
    private string $User_MAIL;
    private string $User_PASSWORD;
    private string $User_NOMROLE = "";
    private bool $User_ISADMIN = false;


    //ToDo Vérifier si l'utilisateur est bien admin pour chaque opération complexe


    //Fonction SQLAjout
    public function SQLAddUser(\PDO $bdd) : array{
        try{
            $requeteboublon = $bdd->prepare("SELECT PSEUDO,MAIL FROM t_users WHERE PSEUDO=:PSEUDO OR MAIL=:MAIL");
            $requeteboublon->execute([
                "PSEUDO" => $this->getUserPSEUDO(),
                "MAIL" => $this->getUserMAIL()
            ]);

            $data = $requeteboublon->fetch(\PDO::FETCH_ASSOC);
            if (empty($data) == false && $data["PSEUDO"] == $this->getUserPSEUDO()){
                return [false, "PSEUDO_DOUBLON"];

            } else if (empty($data) == false && $data["MAIL"] == $this->getUserMAIL()){
                return [false, "MAIL_DOUBLON"];

            } else {
                $requete = $bdd->prepare("INSERT INTO t_users (PSEUDO, MAIL, PASSWORD) VALUES (:PSEUDO, :MAIL, :PASSWORD)");
                $requete->execute([
                    "PSEUDO" => $this->getUserPSEUDO(),
                    "MAIL" => $this->getUserMAIL(),
                    "PASSWORD" => $this->getUserPassword()
                ]);

                return [true,"Inscription réussie !"];
            }

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }

    }

    //Fonction SQLLogin
    public function SQLLoginUser(\PDO $bdd) : array{
        try{
            $requete = $bdd->prepare("SELECT t_users.ID_USER,PSEUDO,PASSWORD,ISADMIN,NAME FROM t_users LEFT JOIN t_roles ON t_users.ID_USER = t_roles.ID_USER WHERE PSEUDO=:PSEUDO");
            $requete->execute([
                "PSEUDO" => $this->getUserPSEUDO()
            ]);

            $data = $requete->fetch(\PDO::FETCH_ASSOC);

            if (password_verify($this->getUserPASSWORD(),trim($data["PASSWORD"]))){
                //Si tous se passe bien return True
                $this->setUserID($data["ID_USER"]);
                if ($data["ISADMIN"] == "1"){
                    $this->setUserISADMIN(true);
                } else {
                    $this->setUserISADMIN(false);
                }

                return [true,"Connexion réussie !"];

            } else {
                return [false,"Utilisateur ou mot de passe incorrect"];
            }

        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Fonction SQLModifier
    public function SQLModifyUser(\PDO $bdd) : array{

        try{
            if (isset($_POST["Password"]) && empty($_POST["Password"] == false)){
                if ($_POST["Password"] == $_POST["PasswordCheck"]){
                    $requete = $bdd->prepare("UPDATE t_users SET PASSWORD=:PASSWORD WHERE PSEUDO=:PSEUDO");
                    $result = $requete->execute([
                        "PSEUDO" => $this->getUserPSEUDO(),
                        "PASSWORD" => $this->getUserPASSWORD()
                    ]);
                    return [true,"Mot de passe enregistré"];
                } else {
                    return [false,"Les mots de passe ne correspondent pas"];
                }

            } elseif (isset($_POST["Email"]) && empty($_POST["Email"]) == false) {
                if ($_POST["Email"] == $_POST["EmailCheck"]) {
                    $requete = $bdd->prepare("UPDATE t_users SET MAIL=:MAIL WHERE PSEUDO=:PSEUDO");
                    $result = $requete->execute([
                        "PSEUDO" => $this->getUserPSEUDO(),
                        "MAIL" => $this->getUserMAIL()
                    ]);
                    return [true,"Email enregistrée"];
                } else {
                    return [false,"Les adresses email ne correspondent pas"];
                }

            } else {
                return [false,"dontmove"];
            }

        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Fonction SQLModifyAdmin
    public function SQLModifyAdmin(\PDO $bdd) : array{
        //SQL de modification pour les admins
        try {
            if((empty($_POST["Email"]) == false) && (isset($_POST["Role"]))){
                //On change l'email et le role
                $requete = $bdd->prepare("UPDATE t_users SET MAIL=:MAIL WHERE ID_USER=:ID_USER");
                $requete->execute([
                    "MAIL" => $this->getUserMAIL(),
                    "ID_USER" => $_GET["param"]
                ]);

                if ($this->getUserNOMROLE() == "null"){
                    $requete = $bdd->prepare("INSERT INTO t_roles (ID_USER,ISADMIN,NAME) VALUES (:ID_USER,1,'Admin')");
                    $requete->execute([
                        "ID_USER" => $_GET["param"]
                    ]);
                }

                return [true,"Email et rôle modifié"];

            } elseif ((empty($_POST["Email"])) && (isset($_POST["Role"]))) {
                //On change le role en admin si il est pas déjà admin
                if ($this->getUserNOMROLE() == "null"){
                    $requete = $bdd->prepare("INSERT INTO t_roles (ID_USER,ISADMIN,NAME) VALUES (:ID_USER,1,'Admin')");
                    $requete->execute([
                        "ID_USER" => $_GET["param"]
                    ]);
                }

                return [true,"Rôle passé à admin (si pas déjà)"];

            } elseif((empty($_POST["Email"]) == false) && (isset($_POST["Role"]) == false)) {
                //On change l'email et on supprime l'admin (si il est présent dans la BDD)
                $requete = $bdd->prepare("UPDATE t_users SET MAIL=:MAIL WHERE ID_USER=:ID_USER");
                $requete->execute([
                    "MAIL" => $this->getUserMAIL(),
                    "ID_USER" => $_GET["param"]
                ]);

                $requete = $bdd->prepare("DELETE FROM t_roles WHERE ID_USER=:ID_USER");
                $requete->execute([
                    "ID_USER" => $_GET["param"]
                ]);

                return [true,"Email modifié et admin supprimé (si présent dans la BDD)"];

            } elseif ((empty($_POST["Email"])) && (isset($_POST["Role"]) == false)) {
                //Si le rôle admin est attribué à l'utilisateur, on le supprime
                $requete = $bdd->prepare("DELETE FROM t_roles WHERE ID_USER=:ID_USER");
                $requete->execute([
                    "ID_USER" => $_GET["param"]
                ]);

                return [true,"Suppression du rôle admin (si il existe)"];

            } else {
                return[false, "Aucune correspondance dans les conditions"];
                exit();
            }

        } catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }

    }

    //Fonction SQLSupprimer
    public function SQLDeleteUser(\PDO $bdd) : array{
        try{
            //Récupération de L'ID User
            $requete = $bdd->prepare("SELECT ID_USER FROM t_users WHERE PSEUDO=:PSEUDO");
            $result = $requete->execute([
                "PSEUDO" => $this->getUserPSEUDO()
            ]);

            $data = $requete->fetch(\PDO::FETCH_ASSOC);
            $this->setUserID($data["ID_USER"]);

            //Vérifie si le compte à supprimer n'est pas le compte sur lequel on est connecté
            if ($this->getUserID() == $_SESSION["ID"]) {
                echo "Impossible de supprimer le compte, vous êtes connecté(e) dessus !";
                exit();
            }

            //Suppression dans la table rôle
            $requete = $bdd->prepare("DELETE FROM t_roles WHERE ID_USER=:ID_USER");
            $result = $requete->execute([
                "ID_USER" => $this->getUserID()
            ]);

            //Suppression dans la table prets
            $requete = $bdd->prepare("DELETE FROM t_prets WHERE ID_USER=:ID_USER");
            $result = $requete->execute([
                "ID_USER" => $this->getUserID()
            ]);

            //Suppression dans la table rôle
            $requete = $bdd->prepare("DELETE FROM t_roles WHERE ID_USER=:ID_USER");
            $result = $requete->execute([
                "ID_USER" => $this->getUserID()
            ]);

            //Suppression dans la table rôle
            $requete = $bdd->prepare("DELETE FROM t_info_movies WHERE ID_USER=:ID_USER");
            $result = $requete->execute([
                "ID_USER" => $this->getUserID()
            ]);


            //Suppression dans la table utilisateur
            $requete = $bdd->prepare("DELETE FROM t_users WHERE ID_USER=:ID_USER");
            $result = $requete->execute([
                "ID_USER" => $this->getUserID()
            ]);

            return [true,'Suppression réalisée avec succès'];

        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }

    //Fonction SQLGetOne
    public function SQLGetOne(\PDO $bdd) : array{
        try{
            $requete = $bdd->prepare("SELECT t_users.ID_USER,PSEUDO,PASSWORD,MAIL,ID_ROLES,ISADMIN,NAME FROM t_users LEFT JOIN t_roles ON t_users.ID_USER = t_roles.ID_USER WHERE t_users.ID_USER=:ID_USER");
            $requete->execute([
                "ID_USER" => $this->getUserID()
            ]);

            $data = $requete->fetch(\PDO::FETCH_ASSOC);
            if ($data == true) {
                $this->setUserID($data["ID_USER"]);
                $this->setUserPSEUDO($data["PSEUDO"]);
                $this->setUserMAIL($data["MAIL"]);

                //Vérification si pas de grade !
                $name = $data["NAME"] ?? "Utilisateur";
                $this->setUserNOMROLE($name);

                $isadmin = $data["ISADMIN"] ?? "0";
                $this->setUserISADMIN($isadmin);

                return [true,$data];
            }

            return [false, "No_Data"];

        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }

    }

    //Fonction SQLGetAll
    public function SQLGetAll(\PDO $bdd) : array{
        try{
            $requete = $bdd->prepare("SELECT t_users.ID_USER,PSEUDO,PASSWORD,ISADMIN,NAME FROM t_users LEFT JOIN t_roles ON t_users.ID_USER = t_roles.ID_USER ORDER BY PSEUDO");
            $requete->execute([]);

            $data = $requete->fetchAll(\PDO::FETCH_ASSOC);
            return [true,$data];

        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }
    }


    //Getters and Setters

    /**
     * @return string Retourne le Pseudo
     */
    public function getUserPSEUDO(): string
    {
        return $this->User_PSEUDO;
    }

    /**
     * @param string $User_PSEUDO Défini le pseudo de l'utilisateur
     */
    public function setUserPSEUDO(string $User_PSEUDO): void
    {
        $this->User_PSEUDO = $User_PSEUDO;
    }

    /**
     * @return string Retourne le mail de l'utilisateur
     */
    public function getUserMAIL(): string
    {
        return $this->User_MAIL;
    }

    /**
     * @param string $User_MAIL Défini le mail de l'utilisateur
     */
    public function setUserMAIL(string $User_MAIL): void
    {
        $this->User_MAIL = $User_MAIL;
    }

    /**
     * @return string Reourne le nom du rôle  de l'utilisateur
     */
    public function getUserNOMROLE(): string
    {
        return $this->User_NOMROLE;
    }

    /**
     * @param string $User_NOMROLE Défini le nom du rôle de l'utilisateur
     */
    public function setUserNOMROLE(string $User_NOMROLE): void
    {
        $this->User_NOMROLE = $User_NOMROLE;
    }

    /**
     * @return bool Retourne si l'utilisateur est Admin
     */
    public function getUserISADMIN(): bool
    {
        return $this->User_ISADMIN;
    }

    /**
     * @param bool $User_ISADMIN Défini si l'utilisateur est admin
     */
    public function setUserISADMIN(bool $User_ISADMIN): void
    {
        $this->User_ISADMIN = $User_ISADMIN;
    }

    /**
     * @return string Retour l'ID d'un utilisateur
     */
    public function getUserID(): string
    {
        return $this->User_ID;
    }

    /**
     * @param string $User_ID Défini l'ID de l'utilisateur
     */
    public function setUserID(string $User_ID): void
    {
        $this->User_ID = $User_ID;
    }

    /**
     * @return string Défini le mot de passe de l'utilisateur
     */
    public function getUserPASSWORD(): string
    {
        return $this->User_PASSWORD;
    }

    /**
     * @param string $User_PASSWORD Défini le mot de passe de l'utilisateur
     */
    public function setUserPASSWORD(string $User_PASSWORD): void
    {
        $this->User_PASSWORD = $User_PASSWORD;
    }
}