<?php

/* themes/gavias_great/templates/page/parts/after-content.html.twig */
class __TwigTemplate_78c7cc8286bd9331cde3390fccc6df1f2eaf9d1153c2d2d68aae6d8a8871712d extends Twig_Template
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
        $tags = array("if" => 1);
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
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "highlighted", array())) {
            // line 2
            echo "  <div class=\"highlighted area\">
    <div class=\"container\">
      ";
            // line 4
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "highlighted", array()), "html", null, true));
            echo "
    </div>
  </div>
";
        }
        // line 8
        echo "
";
        // line 9
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "after_content", array())) {
            // line 10
            echo "  <div class=\"area after_content\">
    <div class=\"container-fw\">
        <div class=\"content-inner\">
         ";
            // line 13
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "after_content", array()), "html", null, true));
            echo "
        </div>
      </div>
  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/parts/after-content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 13,  61 => 10,  59 => 9,  56 => 8,  49 => 4,  45 => 2,  43 => 1,);
    }
}
/* {% if page.highlighted %}*/
/*   <div class="highlighted area">*/
/*     <div class="container">*/
/*       {{ page.highlighted }}*/
/*     </div>*/
/*   </div>*/
/* {% endif %}*/
/* */
/* {% if page.after_content %}*/
/*   <div class="area after_content">*/
/*     <div class="container-fw">*/
/*         <div class="content-inner">*/
/*          {{ page.after_content }}*/
/*         </div>*/
/*       </div>*/
/*   </div>*/
/* {% endif %}*/
