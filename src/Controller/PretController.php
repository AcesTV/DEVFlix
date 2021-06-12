<?php

namespace src\Controller;

use src\Model\Movie;
use src\Model\InfoMovie;
use src\Model\BDD;
use src\Model\Pret;
use src\Model\User;

class PretController extends AbstractController
{

    public function index(){
        $val = new Pret();
        $result = $val->SQLGetOne(BDD::getInstance(),$_GET["param"]);
        var_dump($result);
    }

    //Permet la modification du partage
    public function BtnShareMovie(){
        //ToDo : Fonction pour ajouter une ligne si inéxistante
        //Update si éxistante
    }

    //ToDo : Formulaire pour demande de prêt

    //ToDo : Formulaire pour accepter les demandes de prêt

}
