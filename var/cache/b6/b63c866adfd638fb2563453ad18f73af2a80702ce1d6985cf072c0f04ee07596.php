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

/* InfoMovie/AddInfoMovie.html.twig */
class __TwigTemplate_f287b2a92e5d21f5c52538eb75d4ab7c4905f422a0a70c490a9fcb90ef502a42 extends Template
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

<form name=\"addInfoMovie\" method=\"post\" action=\"?controller=InfoMovie&action=AddInfoMovie\">

    <input id=\"Rate\" type=\"number\" name=\"Rate\" placeholder=\"Note\" value=\"";
        // line 12
        echo twig_escape_filter($this->env, ($context["Rate"] ?? null), "html", null, true);
        echo "\"><br><br>
";
        // line 14
        echo "    <textarea id=\"Comment\" name=\"Comment\" placeholder=\"Commentaire\" rows=\"5\" cols=\"33\" > </textarea>

    <button id=\"btnAdComment\" type=\"submit\">Envoyer</button><br><br>

</form>

<!-- Pour afficher le input en rouge -->
<!-- <script src=\"assets/js/formulaire.js\"></script> -->

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "InfoMovie/AddInfoMovie.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 14,  50 => 12,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">
<head>
    <meta name=\"viewport\" content=\"width=device-width\" initial-scale=1/>

</head>

<body>

<form name=\"addInfoMovie\" method=\"post\" action=\"?controller=InfoMovie&action=AddInfoMovie\">

    <input id=\"Rate\" type=\"number\" name=\"Rate\" placeholder=\"Note\" value=\"{{ Rate }}\"><br><br>
{#    <input id=\"Comment\" type=\"textarea\" name=\"Comment\" placeholder=\"Commentaire\" required rows=\"5\" cols=\"33\"><br><br>#}
    <textarea id=\"Comment\" name=\"Comment\" placeholder=\"Commentaire\" rows=\"5\" cols=\"33\" > </textarea>

    <button id=\"btnAdComment\" type=\"submit\">Envoyer</button><br><br>

</form>

<!-- Pour afficher le input en rouge -->
<!-- <script src=\"assets/js/formulaire.js\"></script> -->

</body>
</html>", "InfoMovie/AddInfoMovie.html.twig", "C:\\xampp2\\htdocs\\Devflix_perso\\templates\\InfoMovie\\AddInfoMovie.html.twig");
    }
}
