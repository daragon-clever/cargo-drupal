<?php

/* themes/gavias_great/templates/page/parts/offcanvas.html.twig */
class __TwigTemplate_98b45d50792a38f9a5d4e85843fae91cab1dc55b0df5e5dff3866c44676d7871 extends Twig_Template
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
        $tags = array("if" => 4);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
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
        echo "<div class=\"offcanvas-sidebar\">
    <div id=\"gva-offcanvas-inner\" class=\"gva-offcanvas-inner\">
      <div class=\"offcanvas-close\"><a><i class=\"fa fa-times\"></i></a></div>
      ";
        // line 4
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "offcanvas", array())) {
            // line 5
            echo "        ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "offcanvas", array()), "html", null, true));
            echo "
      ";
        }
        // line 7
        echo "    </div>
  </div>  ";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/parts/offcanvas.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 7,  50 => 5,  48 => 4,  43 => 1,);
    }
}
/* <div class="offcanvas-sidebar">*/
/*     <div id="gva-offcanvas-inner" class="gva-offcanvas-inner">*/
/*       <div class="offcanvas-close"><a><i class="fa fa-times"></i></a></div>*/
/*       {% if page.offcanvas %}*/
/*         {{ page.offcanvas }}*/
/*       {% endif %}*/
/*     </div>*/
/*   </div>  */
