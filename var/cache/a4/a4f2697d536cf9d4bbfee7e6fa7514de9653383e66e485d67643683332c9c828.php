<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* User/Login.html.twig */
class __TwigTemplate_5876f1b27d55fcf8dfcd6c58468462be31bc8f9303dce8b597858d79ca9bfb74 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"fr\">
<head>


<body>

<form name=\"addUser\" method=\"post\" action=\"?controller=User&action=LoginUser\">

    <input type=\"text\" name=\"Pseudo\" placeholder=\"Pseudo\"><br><br>
    <input type=\"text\" name=\"Password\" placeholder=\"Mot de passe\"><br><br>

    <input type=\"submit\" value=\"Connexion\"><br><br>

</form>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "User/Login.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">
<head>


<body>

<form name=\"addUser\" method=\"post\" action=\"?controller=User&action=LoginUser\">

    <input type=\"text\" name=\"Pseudo\" placeholder=\"Pseudo\"><br><br>
    <input type=\"text\" name=\"Password\" placeholder=\"Mot de passe\"><br><br>

    <input type=\"submit\" value=\"Connexion\"><br><br>

</form>

</body>
</html>", "User/Login.html.twig", "C:\\xampp\\htdocs\\DEVFlix\\templates\\User\\Login.html.twig");
    }
}
