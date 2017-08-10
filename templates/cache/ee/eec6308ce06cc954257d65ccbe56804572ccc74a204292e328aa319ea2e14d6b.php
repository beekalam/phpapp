<?php

/* home.html */
class __TwigTemplate_8e4405853eca762ff8cefa3b9636b3cc1bab02ac4aa9a12d8a18198354d2feb1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
    <head>
\t\t<title>page title</title>
    </head>
    <body>
        <hr/>
        ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["links"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 8
            echo "\t\t\t<a href='";
            echo twig_escape_filter($this->env, $context["item"], "html", null, true);
            echo "'>";
            echo twig_escape_filter($this->env, $context["item"], "html", null, true);
            echo "</a>
\t\t\t<hr/>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "\t\t
\t\t<hr/>
    </body>
</html>

";
    }

    public function getTemplateName()
    {
        return "home.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 11,  31 => 8,  27 => 7,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "home.html", "/var/www/html/test/templates/home.html");
    }
}
