<?php
require "../vendor/autoload.php";

// Autoloader de Classe
function chargerClasse($classe){
    // Windows = \ Linux/Mac = /
    $ds = DIRECTORY_SEPARATOR;
    // Remonte d'un cran par rapport à index.php
    $dir = __DIR__."$ds..";
    $classePath = str_replace("\\", $ds,$classe);
    $file = "{$dir}{$ds}{$classePath}.php";
    if (is_readable($file)){
        require_once $file;
    }
}
spl_autoload_register("chargerClasse");

// Router
$controller = (isset($_GET["controller"])) ? $_GET["controller"] : "";
$action = (isset($_GET["action"])) ? $_GET["action"] : "";
$param = (isset($_GET["param"])) ? $_GET["param"] : "";

//TODO CHANGER LES ARTICLECONTROLLER

if($controller != ''){
    $class = "src\Controller\\".$controller."Controller";
    if(class_exists($class)){
        $controller = new $class;
        if(method_exists($class,$action)){
            echo $controller->$action($param);
        }else{
            echo $controller->index();
        }
    }else{
        $controller = new src\Controller\ArticleController();
        echo $controller->index();
    }
}else{
    $controller = new src\Controller\ArticleController();
    echo $controller->index();
}