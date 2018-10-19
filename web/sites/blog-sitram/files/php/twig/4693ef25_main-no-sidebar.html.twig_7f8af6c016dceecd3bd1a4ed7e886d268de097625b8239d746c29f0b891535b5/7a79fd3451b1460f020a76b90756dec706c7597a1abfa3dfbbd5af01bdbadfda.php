<?php

/* themes/gavias_great/templates/page/main-no-sidebar.html.twig */
class __TwigTemplate_d6880e242233cdadf9b8e9ad6ae8e173a54f29d0c29f726f3e8eeedffcb072b6 extends Twig_Template
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
        $tags = array("set" => 4, "if" => 9);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set', 'if'),
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

        // line 1
        echo "<div class=\"content-main-inner\">
\t<div class=\"row\">
\t\t
\t\t";
        // line 4
        $context["cl_main"] = "col-md-12 col-xs-12";
        // line 5
        echo "\t\t
\t\t<div id=\"page-main-content\" class=\"main-content ";
        // line 6
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["cl_main"]) ? $context["cl_main"] : null), "html", null, true));
        echo "\">

\t\t\t<div class=\"main-content-inner\">
\t\t\t\t";
        // line 9
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content_top", array())) {
            // line 10
            echo "\t\t\t\t\t<div class=\"content-top\">
\t\t\t\t\t\t";
            // line 11
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content_top", array()), "html", null, true));
            echo "
\t\t\t\t\t</div>
\t\t\t\t";
        }
        // line 14
        echo "
\t\t\t\t";
        // line 15
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array())) {
            // line 16
            echo "\t\t\t\t\t<div class=\"content-main\">
\t\t\t\t\t\t";
            // line 17
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array()), "html", null, true));
            echo "
\t\t\t\t\t</div>
\t\t\t\t";
        }
        // line 20
        echo "
\t\t\t\t";
        // line 21
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content_bottom", array())) {
            // line 22
            echo "\t\t\t\t\t<div class=\"content-bottom\">
\t\t\t\t\t\t";
            // line 23
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content_bottom", array()), "html", null, true));
            echo "
\t\t\t\t\t</div>
\t\t\t\t";
        }
        // line 26
        echo "\t\t\t</div>

\t\t</div>
\t\t
\t</div>
</div>


";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/main-no-sidebar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 26,  92 => 23,  89 => 22,  87 => 21,  84 => 20,  78 => 17,  75 => 16,  73 => 15,  70 => 14,  64 => 11,  61 => 10,  59 => 9,  53 => 6,  50 => 5,  48 => 4,  43 => 1,);
    }
}
/* <div class="content-main-inner">*/
/* 	<div class="row">*/
/* 		*/
/* 		{% set cl_main = 'col-md-12 col-xs-12' %}*/
/* 		*/
/* 		<div id="page-main-content" class="main-content {{ cl_main }}">*/
/* */
/* 			<div class="main-content-inner">*/
/* 				{% if page.content_top %}*/
/* 					<div class="content-top">*/
/* 						{{ page.content_top }}*/
/* 					</div>*/
/* 				{% endif %}*/
/* */
/* 				{% if page.content %}*/
/* 					<div class="content-main">*/
/* 						{{ page.content }}*/
/* 					</div>*/
/* 				{% endif %}*/
/* */
/* 				{% if page.content_bottom %}*/
/* 					<div class="content-bottom">*/
/* 						{{ page.content_bottom }}*/
/* 					</div>*/
/* 				{% endif %}*/
/* 			</div>*/
/* */
/* 		</div>*/
/* 		*/
/* 	</div>*/
/* </div>*/
/* */
/* */
/* */
