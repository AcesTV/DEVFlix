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

/* User/test.html.twig */
class __TwigTemplate_1bb7f3d4a31486808469899f018808a5d3c5f839602b876f8a56ecb75c4ebb99 extends Template
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
    <meta name=\"viewport\" content=\"width=device-width\" initial-scale=1/>

</head>

<body>

<form name=\"addUser\" method=\"post\" action=\"?controller=User&action=GetOne\">

    <input id=\"Pseudo\" type=\"text\" name=\"Pseudo\" placeholder=\"Pseudo\" value=\"";
        // line 12
        echo twig_escape_filter($this->env, ($context["Pseudo"] ?? null), "html", null, true);
        echo "\" required><br><br>

    <button id=\"btnsignup\" type=\"submit\">Inscription</button><br><br>

</form>

<!-- Pour afficher le input en rouge -->
<!-- <script src=\"assets/js/formulaire.js\"></script> -->

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "User/test.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 12,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">
<head>
    <meta name=\"viewport\" content=\"width=device-width\" initial-scale=1/>

</head>

<body>

<form name=\"addUser\" method=\"post\" action=\"?controller=User&action=GetOne\">

    <input id=\"Pseudo\" type=\"text\" name=\"Pseudo\" placeholder=\"Pseudo\" value=\"{{ Pseudo }}\" required><br><br>

    <button id=\"btnsignup\" type=\"submit\">Inscription</button><br><br>

</form>

<!-- Pour afficher le input en rouge -->
<!-- <script src=\"assets/js/formulaire.js\"></script> -->

</body>
</html>", "User/test.html.twig", "C:\\xampp2\\htdocs\\Devflix_perso\\templates\\User\\test.html.twig");
    }
}
