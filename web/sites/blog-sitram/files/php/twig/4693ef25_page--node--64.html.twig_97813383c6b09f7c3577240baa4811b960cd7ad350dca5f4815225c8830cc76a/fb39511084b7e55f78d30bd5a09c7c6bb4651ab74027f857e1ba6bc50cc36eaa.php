<?php

/* themes/gavias_great/templates/page/page--node--64.html.twig */
class __TwigTemplate_9e5e375b2329875845b914619b183152a67cf80e7a4e83828d5e3efee9fbfd72 extends Twig_Template
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
        $tags = array("include" => 9, "if" => 17);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('include', 'if'),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setTemplateFile($this->getTemplateName());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 7
        echo "<div class=\"body-page\">
\t
\t";
        // line 9
        $this->loadTemplate(((isset($context["directory"]) ? $context["directory"] : null) . "/templates/page/parts/preloader.html.twig"), "themes/gavias_great/templates/page/page--node--64.html.twig", 9)->display($context);
        // line 10
        echo "\t
\t";
        // line 11
        $this->loadTemplate(((isset($context["directory"]) ? $context["directory"] : null) . (isset($context["header_skin"]) ? $context["header_skin"] : null)), "themes/gavias_great/templates/page/page--node--64.html.twig", 11)->display($context);
        // line 12
        echo "
\t<div role=\"main\" class=\"main main-page\">
\t\t<div id=\"content\" class=\"content content-full\">
\t\t\t<div class=\"container\">
\t\t\t\t<div class=\"page-notfound\">
\t\t\t\t\t";
        // line 17
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array())) {
            // line 18
            echo "\t\t\t\t\t\t<div class=\"content-main\">
\t\t\t\t\t\t\t";
            // line 19
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array()), "html", null, true));
            echo "
\t\t\t\t\t\t</div>
\t\t\t\t\t";
        }
        // line 22
        echo "\t\t\t\t</div>
\t\t\t</div>\t
\t\t</div>
\t</div>

\t";
        // line 27
        $this->loadTemplate(((isset($context["directory"]) ? $context["directory"] : null) . "/templates/page/footer.html.twig"), "themes/gavias_great/templates/page/page--node--64.html.twig", 27)->display($context);
        // line 28
        echo "\t";
        $this->loadTemplate(((isset($context["directory"]) ? $context["directory"] : null) . "/templates/page/parts/offcanvas.html.twig"), "themes/gavias_great/templates/page/page--node--64.html.twig", 28)->display($context);
        // line 29
        echo "</div>

";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/page--node--64.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 29,  81 => 28,  79 => 27,  72 => 22,  66 => 19,  63 => 18,  61 => 17,  54 => 12,  52 => 11,  49 => 10,  47 => 9,  43 => 7,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Gavias's theme implementation to display a single Drupal page.*/
/*  *//* */
/* #}*/
/* <div class="body-page">*/
/* 	*/
/* 	{% include directory ~ '/templates/page/parts/preloader.html.twig' %}*/
/* 	*/
/* 	{% include directory ~ header_skin %}*/
/* */
/* 	<div role="main" class="main main-page">*/
/* 		<div id="content" class="content content-full">*/
/* 			<div class="container">*/
/* 				<div class="page-notfound">*/
/* 					{% if page.content %}*/
/* 						<div class="content-main">*/
/* 							{{ page.content }}*/
/* 						</div>*/
/* 					{% endif %}*/
/* 				</div>*/
/* 			</div>	*/
/* 		</div>*/
/* 	</div>*/
/* */
/* 	{% include directory ~ '/templates/page/footer.html.twig' %}*/
/* 	{% include directory ~ '/templates/page/parts/offcanvas.html.twig' %}*/
/* </div>*/
/* */
/* */
