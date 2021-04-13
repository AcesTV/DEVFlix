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
        //ToDo Ajouter la vérification de mail, si le comtpe éxiste déjà
        try{
            $requete = $bdd->prepare("INSERT INTO t_users (PSEUDO, MAIL, PASSWORD, ID_ROLE) VALUES(:PSEUDO, :MAIL, :PASSWORD, :ID_ROLE)");
            $requete->execute([
                "PSEUDO" => $this->getUserPSEUDO(),
                "MAIL" => $this->getUserMAIL(),
                "PASSWORD" => $this->getUserPassword(),
                "ID_ROLE" => "" //Défini le rôle à rien
            ]);

            //Si tous se passe bien return True
            $_SESSION["ID"] = $this->getUserID();
            $_SESSION["PSEUDO"] = $this->getUserPSEUDO();

            return [true,"Inscription réussie !"];

        } catch (\Exception $e) {
            return [false,$e->getMessage()];
        }

    }

    //Fonction SQLLogin
    public function SQLLoginUser(\PDO $bdd) : array{
        try{
            $requete = $bdd->prepare("SELECT PSEUDO,PASSWORD,ID_ROLE,ISADMIN,NAME FROM t_users LEFT JOIN t_roles ON t_users.ID_USER = t_roles.ID_USER WHERE PSEUDO=:PSEUDO");
            $result = $requete->execute([
                "PSEUDO" => $this->getUserPSEUDO()
            ]);

            $data = $requete->fetch(\PDO::FETCH_ASSOC);

            if (password_verify($this->getUserPASSWORD(),trim($data["PASSWORD"]))){
                //Si tous se passe bien return True
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
            //ToDo Ajouter ancien mot de passe pour pouvoir changer
            //TODO Ajouter vérif si MDP = MDP VERIF
            //TODO Ajouter vérif si MAIL = MAIL VERIF
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
        //Formulaire pour les admin
        try {
            echo "Nom role = ".$this->getUserNOMROLE();
            if ($this->getUserNOMROLE() == ""){
                echo "ICI1";
                $requete = $bdd->prepare("INSERT INTO t_roles (ID_USER, ISADMIN, NAME) VALUES (:ID_USER, :ISADMIN, :NAME)");
                $requete->execute([
                    "ID_USER" => $this->getUserID(),
                    "ISADMIN" => $this->getUserISADMIN(),
                    "NAME" => $this->getUserNOMROLE()
                ]);
            } else {
                echo "ICI2";
                $requete = $bdd->prepare("UPDATE t_roles SET ISADMIN=:ISADMIN, NAME=:NAME WHERE ID_USER=:ID_USER");
                $requete->execute([
                   "ISADMIN" => $this->getUserISADMIN(),
                   "NAME" => $this->getUserNOMROLE(),
                   "ID_USER" => $this->getUserID()
                ]);
            }

            return[true,"Modification réussie"];




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

    //Fonction SQLGet
    public function SQLGetOne(\PDO $bdd) : array{
        try{
            $requete = $bdd->prepare("SELECT PSEUDO,PASSWORD,ID_ROLE,ISADMIN,NAME FROM t_users LEFT JOIN t_roles ON t_users.ID_USER = t_roles.ID_USER WHERE PSEUDO=:PSEUDO");
            $result = $requete->execute([
                "PSEUDO" => $this->getUserPSEUDO()
            ]);

            $data = $requete->fetch(\PDO::FETCH_ASSOC);
            $this->setUserID($data["ID_USER"]);
            $this->setUserPSEUDO($data["PSEUDO"]);
            $this->setUserMAIL($data["MAIL"]);
            $this->setUserNOMROLE($data["NAME"]);
            $this->setUserISADMIN($data["ISADMIN"]);

            return [true,$data];


        }catch (\Exception $e){
            return [false,"Une erreur c'est produite : ".$e->getMessage()];
        }

    }

    //Fonction SQLGetAll
    public function SQLGetAll(\PDO $bdd) : array{
        try{
            $requete = $bdd->prepare("SELECT PSEUDO,PASSWORD,ID_ROLE,ISADMIN,NAME FROM t_users LEFT JOIN t_roles ON t_users.ID_USER = t_roles.ID_USER");
            $result = $requete->execute([]);

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

    /**
     * @return string
     */
    public function getSQLPARAM(): string
    {
        return $this->SQLPARAM;
    }

    /**
     * @param string $SQLPARAM
     */
    public function setSQLPARAM(string $SQLPARAM): void
    {
        $this->SQLPARAM = $SQLPARAM;
    }



}