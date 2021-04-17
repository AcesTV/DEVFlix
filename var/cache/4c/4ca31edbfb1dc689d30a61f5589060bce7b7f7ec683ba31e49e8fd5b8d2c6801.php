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

/* User/AddUser.html.twig */
class __TwigTemplate_6a5fce873bd500469f095ac78657d98050cdbfea47e4832ea4f5bac555f14e7d extends Template
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

    <form name=\"addUser\" method=\"post\" action=\"?controller=User&action=AddUser\">

        <input id=\"Pseudo\" type=\"text\" name=\"Pseudo\" placeholder=\"Pseudo\" value=\"";
        // line 12
        echo twig_escape_filter($this->env, ($context["Pseudo"] ?? null), "html", null, true);
        echo "\" required><br><br>
        <input id=\"Password\" type=\"password\" name=\"Password\" placeholder=\"Mot de passe\" required><br><br>
        <input id=\"Passwordcheck\" type=\"password\" name=\"Passwordcheck\" placeholder=\"Vérification mot de passe\" required><br><br>
        <input id=\"Email\" type=\"email\" name=\"Email\" placeholder=\"Votre email\" value=\"";
        // line 15
        echo twig_escape_filter($this->env, ($context["Email"] ?? null), "html", null, true);
        echo "\" required><br><br>
        <input id=\"Emailcheck\" type=\"email\" name=\"Emailcheck\" placeholder=\"Vérification email\" required><br><br>

        <button id=\"btnsignup\" type=\"submit\">Inscription</button><br><br>

    </form>

    <!-- Pour afficher le input en rouge -->
    <!-- <script src=\"assets/js/formulaire.js\"></script> -->

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "User/AddUser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 15,  50 => 12,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">
<head>
    <meta name=\"viewport\" content=\"width=device-width\" initial-scale=1/>

</head>

<body>

    <form name=\"addUser\" method=\"post\" action=\"?controller=User&action=AddUser\">

        <input id=\"Pseudo\" type=\"text\" name=\"Pseudo\" placeholder=\"Pseudo\" value=\"{{ Pseudo }}\" required><br><br>
        <input id=\"Password\" type=\"password\" name=\"Password\" placeholder=\"Mot de passe\" required><br><br>
        <input id=\"Passwordcheck\" type=\"password\" name=\"Passwordcheck\" placeholder=\"Vérification mot de passe\" required><br><br>
        <input id=\"Email\" type=\"email\" name=\"Email\" placeholder=\"Votre email\" value=\"{{ Email }}\" required><br><br>
        <input id=\"Emailcheck\" type=\"email\" name=\"Emailcheck\" placeholder=\"Vérification email\" required><br><br>

        <button id=\"btnsignup\" type=\"submit\">Inscription</button><br><br>

    </form>

    <!-- Pour afficher le input en rouge -->
    <!-- <script src=\"assets/js/formulaire.js\"></script> -->

</body>
</html>", "User/AddUser.html.twig", "C:\\xampp2\\htdocs\\Devflix_perso\\templates\\User\\AddUser.html.twig");
    }
}
