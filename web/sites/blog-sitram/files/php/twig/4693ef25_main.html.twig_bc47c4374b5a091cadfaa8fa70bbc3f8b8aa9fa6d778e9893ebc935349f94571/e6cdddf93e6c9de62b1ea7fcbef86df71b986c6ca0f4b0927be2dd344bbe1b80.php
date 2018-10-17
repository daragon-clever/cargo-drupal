<?php

/* themes/gavias_great/templates/page/main.html.twig */
class __TwigTemplate_992f862c4774353e29e305ba395888d08a124e93d603c627e96763cee8bf0641 extends Twig_Template
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
        $tags = array("set" => 4, "if" => 5);
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
        echo "\t\t";
        if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_right", array()) && $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_left", array()))) {
            echo "\t
\t\t\t";
            // line 6
            $context["cl_main"] = "col-xs-12 col-md-6 col-md-push-3 sb-r sb-l ";
            // line 7
            echo "\t\t";
        } elseif (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_right", array()) || $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_left", array()))) {
            echo "\t
\t\t\t";
            // line 8
            if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_right", array())) {
                // line 9
                echo "\t\t\t \t";
                $context["cl_main"] = "col-xs-12 col-md-8 sb-r ";
                // line 10
                echo "\t\t\t";
            }
            echo " \t\t
\t\t\t";
            // line 11
            if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_left", array())) {
                // line 12
                echo "\t\t\t\t";
                $context["cl_main"] = "col-xs-12 col-md-8 col-md-push-4 sb-l ";
                // line 13
                echo "\t\t\t";
            }
            echo "\t\t\t\t
      ";
        }
        // line 14
        echo " 

\t\t<div id=\"page-main-content\" class=\"main-content ";
        // line 16
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["cl_main"]) ? $context["cl_main"] : null), "html", null, true));
        echo "\">

\t\t\t<div class=\"main-content-inner\">
\t\t\t\t";
        // line 19
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content_top", array())) {
            // line 20
            echo "\t\t\t\t\t<div class=\"content-top\">
\t\t\t\t\t\t";
            // line 21
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content_top", array()), "html", null, true));
            echo "
\t\t\t\t\t</div>
\t\t\t\t";
        }
        // line 24
        echo "
\t\t\t\t";
        // line 25
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array())) {
            // line 26
            echo "\t\t\t\t\t<div class=\"content-main\">
\t\t\t\t\t\t";
            // line 27
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array()), "html", null, true));
            echo "
\t\t\t\t\t</div>
\t\t\t\t";
        }
        // line 30
        echo "
\t\t\t\t";
        // line 31
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content_bottom", array())) {
            // line 32
            echo "\t\t\t\t\t<div class=\"content-bottom\">
\t\t\t\t\t\t";
            // line 33
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content_bottom", array()), "html", null, true));
            echo "
\t\t\t\t\t</div>
\t\t\t\t";
        }
        // line 36
        echo "\t\t\t</div>

\t\t</div>

\t\t<!-- Sidebar Left -->
\t\t";
        // line 41
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_left", array())) {
            // line 42
            echo "\t\t\t
\t\t\t";
            // line 43
            $context["cl_left"] = "col-md-4 col-md-pull-8 col-sm-12 col-xs-12";
            // line 44
            echo "\t\t\t";
            if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_right", array())) {
                // line 45
                echo "\t\t\t \t";
                $context["cl_left"] = "col-md-3 col-md-pull-6 col-sm-12 col-xs-12";
                // line 46
                echo "\t\t\t";
            }
            echo " \t\t
\t\t\t
\t\t\t<div class=\"";
            // line 48
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["cl_left"]) ? $context["cl_left"] : null), "html", null, true));
            echo " sidebar sidebar-left\">
\t\t\t\t<div class=\"sidebar-inner\">
\t\t\t\t\t";
            // line 50
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_left", array()), "html", null, true));
            echo "
\t\t\t\t</div>
\t\t\t</div>
\t\t";
        }
        // line 54
        echo "\t\t<!-- End Sidebar Left -->

\t\t<!-- Sidebar Right -->
\t\t";
        // line 57
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_right", array())) {
            // line 58
            echo "\t\t\t
\t\t\t";
            // line 59
            $context["cl_right"] = "col-lg-4 col-md-4 col-sm-12 col-xs-12";
            // line 60
            echo "\t\t\t";
            if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_left", array())) {
                // line 61
                echo "\t\t\t\t";
                $context["cl_right"] = "col-lg-3 col-md-3 col-sm-12 col-xs-12";
                // line 62
                echo "\t\t\t";
            }
            echo "\t 

\t\t\t<div class=\"";
            // line 64
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["cl_right"]) ? $context["cl_right"] : null), "html", null, true));
            echo " sidebar sidebar-right theiaStickySidebar\">
\t\t\t\t<div class=\"sidebar-inner\">
\t\t\t\t\t";
            // line 66
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_right", array()), "html", null, true));
            echo "
\t\t\t\t</div>
\t\t\t</div>
\t\t";
        }
        // line 70
        echo "\t\t<!-- End Sidebar Right -->
\t\t
\t</div>
</div>


";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/main.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  206 => 70,  199 => 66,  194 => 64,  188 => 62,  185 => 61,  182 => 60,  180 => 59,  177 => 58,  175 => 57,  170 => 54,  163 => 50,  158 => 48,  152 => 46,  149 => 45,  146 => 44,  144 => 43,  141 => 42,  139 => 41,  132 => 36,  126 => 33,  123 => 32,  121 => 31,  118 => 30,  112 => 27,  109 => 26,  107 => 25,  104 => 24,  98 => 21,  95 => 20,  93 => 19,  87 => 16,  83 => 14,  77 => 13,  74 => 12,  72 => 11,  67 => 10,  64 => 9,  62 => 8,  57 => 7,  55 => 6,  50 => 5,  48 => 4,  43 => 1,);
    }
}
/* <div class="content-main-inner">*/
/* 	<div class="row">*/
/* 		*/
/* 		{% set cl_main = 'col-md-12 col-xs-12' %}*/
/* 		{% if page.sidebar_right and page.sidebar_left %}	*/
/* 			{% set cl_main = 'col-xs-12 col-md-6 col-md-push-3 sb-r sb-l ' %}*/
/* 		{% elseif page.sidebar_right or page.sidebar_left %}	*/
/* 			{% if page.sidebar_right %}*/
/* 			 	{% set cl_main = 'col-xs-12 col-md-8 sb-r ' %}*/
/* 			{% endif %} 		*/
/* 			{% if page.sidebar_left %}*/
/* 				{% set cl_main = 'col-xs-12 col-md-8 col-md-push-4 sb-l ' %}*/
/* 			{% endif %}				*/
/*       {% endif %} */
/* */
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
/* */
/* 		<!-- Sidebar Left -->*/
/* 		{% if page.sidebar_left %}*/
/* 			*/
/* 			{% set cl_left = 'col-md-4 col-md-pull-8 col-sm-12 col-xs-12' %}*/
/* 			{%	if page.sidebar_right %}*/
/* 			 	{% set cl_left = 'col-md-3 col-md-pull-6 col-sm-12 col-xs-12' %}*/
/* 			{% endif %} 		*/
/* 			*/
/* 			<div class="{{ cl_left }} sidebar sidebar-left">*/
/* 				<div class="sidebar-inner">*/
/* 					{{ page.sidebar_left }}*/
/* 				</div>*/
/* 			</div>*/
/* 		{% endif %}*/
/* 		<!-- End Sidebar Left -->*/
/* */
/* 		<!-- Sidebar Right -->*/
/* 		{% if page.sidebar_right %}*/
/* 			*/
/* 			{% set cl_right = 'col-lg-4 col-md-4 col-sm-12 col-xs-12'  %}*/
/* 			{% if page.sidebar_left %}*/
/* 				{% set cl_right = 'col-lg-3 col-md-3 col-sm-12 col-xs-12' %}*/
/* 			{% endif %}	 */
/* */
/* 			<div class="{{ cl_right }} sidebar sidebar-right theiaStickySidebar">*/
/* 				<div class="sidebar-inner">*/
/* 					{{ page.sidebar_right }}*/
/* 				</div>*/
/* 			</div>*/
/* 		{% endif %}*/
/* 		<!-- End Sidebar Right -->*/
/* 		*/
/* 	</div>*/
/* </div>*/
/* */
/* */
/* */
