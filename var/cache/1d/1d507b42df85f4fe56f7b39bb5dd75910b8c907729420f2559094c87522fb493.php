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

/* Movie/updateMovie.html.twig */
class __TwigTemplate_cd7a9154851b11dafe6172227c4e612cbf37223f570d1441b3a41453998326e9 extends Template
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
        $this->parent = $this->loadTemplate("base.html.twig", "Movie/updateMovie.html.twig", 1);
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
        echo "    <h1>Update de <a href=\"?controller=movie&action=showonemovie&param=";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "ID_MOVIE", [], "any", false, false, false, 10), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "NAME", [], "any", false, false, false, 10), "html", null, true);
        echo "</a></h1>

    <form name=\"addMovie\" method=\"post\" action=\"?controller=Movie&action=UpdateMovie&param=";
        // line 12
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "ID_MOVIE", [], "any", false, false, false, 12), "html", null, true);
        echo "\">
        <input id=\"Name\" type=\"text\" name=\"Name\" placeholder=\"Name\" value=\"";
        // line 13
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "NAME", [], "any", false, false, false, 13), "html", null, true);
        echo "\" required>
        <input id=\"Poster\" type=\"text\" name=\"Poster\" placeholder=\"Link Poster\" value=\"";
        // line 14
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "POSTER", [], "any", false, false, false, 14), "html", null, true);
        echo "\" required>
        <input id=\"Origin\" type=\"text\" name=\"Origin\" placeholder=\"Origin\" value=\"";
        // line 15
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "ORIGIN", [], "any", false, false, false, 15), "html", null, true);
        echo "\">
        <input id=\"VO\" type=\"text\" name=\"VO\" placeholder=\"VO\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "VO", [], "any", false, false, false, 16), "html", null, true);
        echo "\">
        <input id=\"Actors\" type=\"text\" name=\"Actors\" placeholder=\"Actors\" value=\"";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "ACTORS", [], "any", false, false, false, 17), "html", null, true);
        echo "\">
        <input id=\"Director\" type=\"text\" name=\"Director\" placeholder=\"Director\" value=\"";
        // line 18
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "DIRECTOR", [], "any", false, false, false, 18), "html", null, true);
        echo "\">
        <input id=\"Genre\" type=\"text\" name=\"Genre\" placeholder=\"Genre\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "GENRE", [], "any", false, false, false, 19), "html", null, true);
        echo "\">
        <input id=\"ReleaseDate\" type=\"date\" name=\"ReleaseDate\" placeholder=\"ReleaseDate\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "RELEASE_DATE", [], "any", false, false, false, 20), "html", null, true);
        echo "\">
        <input id=\"Production\" type=\"text\" name=\"Production\" placeholder=\"Production\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "PRODUCTION", [], "any", false, false, false, 21), "html", null, true);
        echo "\">
        <input id=\"Runtime\" type=\"number\" name=\"Runtime\" placeholder=\"Runtime\" value=\"";
        // line 22
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "RUNTIME", [], "any", false, false, false, 22), "html", null, true);
        echo "\" required>
        <input id=\"Trailer\" type=\"text\" name=\"Trailer\" placeholder=\"Link Trailer\" value=\"";
        // line 23
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "TRAILER", [], "any", false, false, false, 23), "html", null, true);
        echo "\">
        <input id=\"Nomination\" type=\"text\" name=\"Nomination\" placeholder=\"Nomination\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "NOMINATION", [], "any", false, false, false, 24), "html", null, true);
        echo "\">
        <input id=\"Synopsis\" type=\"text\" name=\"Synopsis\" placeholder=\"Synopsis\" value=\"";
        // line 25
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "SYNOPSIS", [], "any", false, false, false, 25), "html", null, true);
        echo "\" required>
        <input id=\"DVD\" type=\"checkbox\" name=\"DVD\" ";
        // line 26
        if ((twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "DVD", [], "any", false, false, false, 26) == 1)) {
            echo " checked ";
        }
        echo ">

        <input type=\"submit\" value=\"Submit Movie\">
    </form>
";
    }

    public function getTemplateName()
    {
        return "Movie/updateMovie.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  133 => 26,  129 => 25,  125 => 24,  121 => 23,  117 => 22,  113 => 21,  109 => 20,  105 => 19,  101 => 18,  97 => 17,  93 => 16,  89 => 15,  85 => 14,  81 => 13,  77 => 12,  69 => 10,  65 => 9,  60 => 6,  56 => 5,  48 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends\"base.html.twig\" %}

{% block title %}Movies - {{ parent() }}{% endblock %}

{% block css %}
    <link rel=\"stylesheet\" href=\"/assets/css/mystyleForMovie.css\">
{% endblock %}

{% block body %}
    <h1>Update de <a href=\"?controller=movie&action=showonemovie&param={{ movie.ID_MOVIE }}\">{{ movie.NAME }}</a></h1>

    <form name=\"addMovie\" method=\"post\" action=\"?controller=Movie&action=UpdateMovie&param={{ movie.ID_MOVIE }}\">
        <input id=\"Name\" type=\"text\" name=\"Name\" placeholder=\"Name\" value=\"{{ movie.NAME }}\" required>
        <input id=\"Poster\" type=\"text\" name=\"Poster\" placeholder=\"Link Poster\" value=\"{{ movie.POSTER }}\" required>
        <input id=\"Origin\" type=\"text\" name=\"Origin\" placeholder=\"Origin\" value=\"{{ movie.ORIGIN }}\">
        <input id=\"VO\" type=\"text\" name=\"VO\" placeholder=\"VO\" value=\"{{ movie.VO }}\">
        <input id=\"Actors\" type=\"text\" name=\"Actors\" placeholder=\"Actors\" value=\"{{ movie.ACTORS }}\">
        <input id=\"Director\" type=\"text\" name=\"Director\" placeholder=\"Director\" value=\"{{ movie.DIRECTOR }}\">
        <input id=\"Genre\" type=\"text\" name=\"Genre\" placeholder=\"Genre\" value=\"{{ movie.GENRE }}\">
        <input id=\"ReleaseDate\" type=\"date\" name=\"ReleaseDate\" placeholder=\"ReleaseDate\" value=\"{{ movie.RELEASE_DATE }}\">
        <input id=\"Production\" type=\"text\" name=\"Production\" placeholder=\"Production\" value=\"{{ movie.PRODUCTION }}\">
        <input id=\"Runtime\" type=\"number\" name=\"Runtime\" placeholder=\"Runtime\" value=\"{{ movie.RUNTIME }}\" required>
        <input id=\"Trailer\" type=\"text\" name=\"Trailer\" placeholder=\"Link Trailer\" value=\"{{ movie.TRAILER }}\">
        <input id=\"Nomination\" type=\"text\" name=\"Nomination\" placeholder=\"Nomination\" value=\"{{ movie.NOMINATION }}\">
        <input id=\"Synopsis\" type=\"text\" name=\"Synopsis\" placeholder=\"Synopsis\" value=\"{{ movie.SYNOPSIS }}\" required>
        <input id=\"DVD\" type=\"checkbox\" name=\"DVD\" {% if movie.DVD == 1%} checked {% endif %}>

        <input type=\"submit\" value=\"Submit Movie\">
    </form>
{% endblock %}

", "Movie/updateMovie.html.twig", "C:\\xampp2\\htdocs\\Devflix_perso\\templates\\Movie\\updateMovie.html.twig");
    }
}
