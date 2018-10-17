<?php

/* themes/gavias_great/templates/page/parts/before-content.html.twig */
class __TwigTemplate_0506fcb471b431271d2bf141192d357b906f146714c5e2f2d4fcacf4fae8208d extends Twig_Template
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
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "fw_promotion", array())) {
            // line 2
            echo "  <div class=\"promotion-fw area\">
    <div class=\"content-inner\">
      ";
            // line 4
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "fw_promotion", array()), "html", null, true));
            echo "
    </div>  
  </div>
";
        }
        // line 7
        echo " 

";
        // line 9
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "promotion", array())) {
            // line 10
            echo "  <div class=\"promotion area\">
    <div class=\"container\">
      <div class=\"content-inner\">
        ";
            // line 13
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "promotion", array()), "html", null, true));
            echo "
      </div>
    </div>    
  </div>
";
        }
        // line 17
        echo " 

";
        // line 19
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "help", array())) {
            // line 20
            echo "  <div class=\"help\">
    <div class=\"container\">
      <div class=\"content-inner\">
        ";
            // line 23
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "help", array()), "html", null, true));
            echo "
      </div>
    </div>
  </div>
";
        }
        // line 28
        echo "
";
        // line 29
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "fw_before_content", array())) {
            // line 30
            echo "  <div class=\"fw-before-content area\">
    ";
            // line 31
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "fw_before_content", array()), "html", null, true));
            echo "
  </div>
";
        }
        // line 34
        echo "
<div class=\"clearfix\"></div>
";
        // line 36
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "before_content", array())) {
            // line 37
            echo "  <div class=\"before_content area\">
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-xs-12\">
          ";
            // line 41
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "before_content", array()), "html", null, true));
            echo "
          </div>
      </div>
    </div>
  </div>
";
        }
        // line 47
        echo "<div class=\"clearfix\"></div>";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/parts/before-content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 47,  120 => 41,  114 => 37,  112 => 36,  108 => 34,  102 => 31,  99 => 30,  97 => 29,  94 => 28,  86 => 23,  81 => 20,  79 => 19,  75 => 17,  67 => 13,  62 => 10,  60 => 9,  56 => 7,  49 => 4,  45 => 2,  43 => 1,);
    }
}
/* {% if page.fw_promotion %}*/
/*   <div class="promotion-fw area">*/
/*     <div class="content-inner">*/
/*       {{ page.fw_promotion }}*/
/*     </div>  */
/*   </div>*/
/* {% endif %} */
/* */
/* {% if page.promotion %}*/
/*   <div class="promotion area">*/
/*     <div class="container">*/
/*       <div class="content-inner">*/
/*         {{ page.promotion }}*/
/*       </div>*/
/*     </div>    */
/*   </div>*/
/* {% endif %} */
/* */
/* {% if page.help %}*/
/*   <div class="help">*/
/*     <div class="container">*/
/*       <div class="content-inner">*/
/*         {{ page.help }}*/
/*       </div>*/
/*     </div>*/
/*   </div>*/
/* {% endif %}*/
/* */
/* {% if page.fw_before_content %}*/
/*   <div class="fw-before-content area">*/
/*     {{ page.fw_before_content }}*/
/*   </div>*/
/* {% endif %}*/
/* */
/* <div class="clearfix"></div>*/
/* {% if page.before_content %}*/
/*   <div class="before_content area">*/
/*     <div class="container">*/
/*       <div class="row">*/
/*         <div class="col-xs-12">*/
/*           {{ page.before_content }}*/
/*           </div>*/
/*       </div>*/
/*     </div>*/
/*   </div>*/
/* {% endif %}*/
/* <div class="clearfix"></div>*/
