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

/* Movie/list.html.twig */
class __TwigTemplate_e68dbeac4df0d436b07bd1eef269e403f5d414ec2c6928f897a98883dce2e930 extends Template
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
        $this->parent = $this->loadTemplate("base.html.twig", "Movie/list.html.twig", 1);
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
        echo "
    ";
        // line 11
        if (array_key_exists("movieList", $context)) {
            // line 12
            echo "        <h1>Liste des Films</h1>
        ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["movieList"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["movie"]) {
                // line 14
                echo "        <h2>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["movie"], "NAME", [], "any", false, false, false, 14), "html", null, true);
                echo "</h2>
        <p>";
                // line 15
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["movie"], "RELEASE_DATE", [], "any", false, false, false, 15), "html", null, true);
                echo "</p>
        <p>";
                // line 16
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["movie"], "SYNOPSIS", [], "any", false, false, false, 16), "html", null, true);
                echo "</p>
        <hr>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['movie'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            echo "    ";
        } else {
            // line 20
            echo "        <h1>Détail de ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "NAME", [], "any", false, false, false, 20), "html", null, true);
            echo "</h1>
        <h2>";
            // line 21
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "NAME", [], "any", false, false, false, 21), "html", null, true);
            echo "</h2>
        <p>";
            // line 22
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "RELEASE_DATE", [], "any", false, false, false, 22), "html", null, true);
            echo "</p>
        <p>";
            // line 23
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["movie"] ?? null), "SYNOPSIS", [], "any", false, false, false, 23), "html", null, true);
            echo "</p>
        <hr>
    ";
        }
    }

    public function getTemplateName()
    {
        return "Movie/list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  115 => 23,  111 => 22,  107 => 21,  102 => 20,  99 => 19,  90 => 16,  86 => 15,  81 => 14,  77 => 13,  74 => 12,  72 => 11,  69 => 10,  65 => 9,  60 => 6,  56 => 5,  48 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends\"base.html.twig\" %}

{% block title %}Movies - {{ parent() }}{% endblock %}

{% block css %}
    <link rel=\"stylesheet\" href=\"/assets/css/mystyleForMovie.css\">
{% endblock %}

{% block body %}

    {% if movieList is defined %}
        <h1>Liste des Films</h1>
        {% for movie in movieList %}
        <h2>{{ movie.NAME }}</h2>
        <p>{{ movie.RELEASE_DATE }}</p>
        <p>{{ movie.SYNOPSIS }}</p>
        <hr>
        {% endfor %}
    {% else %}
        <h1>Détail de {{ movie.NAME }}</h1>
        <h2>{{ movie.NAME }}</h2>
        <p>{{ movie.RELEASE_DATE }}</p>
        <p>{{ movie.SYNOPSIS }}</p>
        <hr>
    {% endif %}
{% endblock %}
", "Movie/list.html.twig", "C:\\xampp2\\htdocs\\Devflix_perso\\templates\\Movie\\list.html.twig");
    }
}
