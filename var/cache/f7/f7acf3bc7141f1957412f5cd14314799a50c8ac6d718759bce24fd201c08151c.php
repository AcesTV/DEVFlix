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

/* Movie/addMovie.html.twig */
class __TwigTemplate_fa4c26d7f1edc59c3d8759e4543690cfaef3b5d1b541a42f3676499f0f33611b extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'css' => [$this, 'block_css'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "Movie/addMovie.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Movies - ";
        $this->displayParentBlock("title", $context, $blocks);
    }

    // line 5
    public function block_css($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 6
        echo "    <link rel=\"stylesheet\" href=\"/assets/css/mystyleForMovie.css\">
";
    }

    // line 9
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 10
        echo "    <h1>Ajout d'un film</h1>

    <form name=\"addMovie\" method=\"post\" action=\"?controller=Movie&action=AddMovie\">
        <input id=\"Name\" type=\"text\" name=\"Name\" placeholder=\"Name\" required>
        <input id=\"Poster\" type=\"text\" name=\"Poster\" placeholder=\"Link Poster\" required>
        <input id=\"Origin\" type=\"text\" name=\"Origin\" placeholder=\"Origin\">
        <input id=\"VO\" type=\"text\" name=\"VO\" placeholder=\"VO\">
        <input id=\"Actors\" type=\"text\" name=\"Actors\" placeholder=\"Actors\">
        <input id=\"Director\" type=\"text\" name=\"Director\" placeholder=\"Director\">
        <input id=\"Genre\" type=\"text\" name=\"Genre\" placeholder=\"Genre\">
        <input id=\"ReleaseDate\" type=\"date\" name=\"ReleaseDate\" placeholder=\"ReleaseDate\">
        <input id=\"Production\" type=\"text\" name=\"Production\" placeholder=\"Production\">
        <input id=\"Runtime\" type=\"number\" name=\"Runtime\" placeholder=\"Runtime\" required>
        <input id=\"Trailer\" type=\"text\" name=\"Trailer\" placeholder=\"Link Trailer\">
        <input id=\"Nomination\" type=\"text\" name=\"Nomination\" placeholder=\"Nomination\">
        <input id=\"Synopsis\" type=\"text\" name=\"Synopsis\" placeholder=\"Synopsis\" required>
        <input id=\"DVD\" type=\"checkbox\" name=\"DVD\" required>

        <input type=\"submit\" value=\"Submit Movie\">
    </form>
";
    }

    public function getTemplateName()
    {
        return "Movie/addMovie.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 10,  65 => 9,  60 => 6,  56 => 5,  48 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends\"base.html.twig\" %}

{% block title %}Movies - {{ parent() }}{% endblock %}

{% block css %}
    <link rel=\"stylesheet\" href=\"/assets/css/mystyleForMovie.css\">
{% endblock %}

{% block body %}
    <h1>Ajout d'un film</h1>

    <form name=\"addMovie\" method=\"post\" action=\"?controller=Movie&action=AddMovie\">
        <input id=\"Name\" type=\"text\" name=\"Name\" placeholder=\"Name\" required>
        <input id=\"Poster\" type=\"text\" name=\"Poster\" placeholder=\"Link Poster\" required>
        <input id=\"Origin\" type=\"text\" name=\"Origin\" placeholder=\"Origin\">
        <input id=\"VO\" type=\"text\" name=\"VO\" placeholder=\"VO\">
        <input id=\"Actors\" type=\"text\" name=\"Actors\" placeholder=\"Actors\">
        <input id=\"Director\" type=\"text\" name=\"Director\" placeholder=\"Director\">
        <input id=\"Genre\" type=\"text\" name=\"Genre\" placeholder=\"Genre\">
        <input id=\"ReleaseDate\" type=\"date\" name=\"ReleaseDate\" placeholder=\"ReleaseDate\">
        <input id=\"Production\" type=\"text\" name=\"Production\" placeholder=\"Production\">
        <input id=\"Runtime\" type=\"number\" name=\"Runtime\" placeholder=\"Runtime\" required>
        <input id=\"Trailer\" type=\"text\" name=\"Trailer\" placeholder=\"Link Trailer\">
        <input id=\"Nomination\" type=\"text\" name=\"Nomination\" placeholder=\"Nomination\">
        <input id=\"Synopsis\" type=\"text\" name=\"Synopsis\" placeholder=\"Synopsis\" required>
        <input id=\"DVD\" type=\"checkbox\" name=\"DVD\" required>

        <input type=\"submit\" value=\"Submit Movie\">
    </form>
{% endblock %}

", "Movie/addMovie.html.twig", "C:\\xampp2\\htdocs\\Devflix_perso\\templates\\Movie\\addMovie.html.twig");
    }
}
