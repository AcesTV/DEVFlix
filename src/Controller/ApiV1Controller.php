<?php
namespace src\Controller;

// Une API retourne du JSON (ou du XML)
use src\Model\Article;
use src\Model\Movie;
use src\Model\BDD;

class ApiV1Controller {

    public function index(){
        header("location:/");
    }

    public function articles(){
        $method = $_SERVER["REQUEST_METHOD"];
        header("Content-Type: application/json");

        if($method=="GET"){
            $VarMovie = new Movie();
            $AllArticle = $VarMovie->SQLGetAll(BDD::getInstance());

            return json_encode($AllArticle);
        }

        header("HTTP/1.1 405 Method Not Allowed");
        return json_encode("Erreur : votre méthode $method n'est pas reconnue");

    }

    public function article($id=null){
        $method = $_SERVER["REQUEST_METHOD"];
        header("Content-Type: application/json");

        //Récupération d'un seul film
        if($method == "GET"){
            if($id==null){
                header("HTTP/1.1 403 Forbidden");
                return json_encode("Erreur : Il manque un ID");
            }
            $VarMovie = new Movie();
            $OneArticle = $VarMovie->SQLGetOne(BDD::getInstance(), $id);

            return json_encode($OneArticle);
        }


        header("HTTP/1.1 405 Method Not Allowed");
        return json_encode("Erreur : votre méthode $method n'est pas reconnue");
    }



}