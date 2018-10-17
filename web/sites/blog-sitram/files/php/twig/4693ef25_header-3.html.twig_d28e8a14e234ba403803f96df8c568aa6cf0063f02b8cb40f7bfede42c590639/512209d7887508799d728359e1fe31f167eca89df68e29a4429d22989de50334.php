<?php

/* themes/gavias_great/templates/page/header-3.html.twig */
class __TwigTemplate_dfea4ed079ffa87430cce655e2ca9ba7207bbf6d2e41ef3252e3af009ceddf34 extends Twig_Template
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
        $tags = array("include" => 3, "if" => 11);
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

        // line 1
        echo "<header id=\"header\" class=\"header-v3\">
  
  ";
        // line 3
        $this->loadTemplate(((isset($context["directory"]) ? $context["directory"] : null) . "/templates/page/parts/topbar.html.twig"), "themes/gavias_great/templates/page/header-3.html.twig", 3)->display($context);
        // line 4
        echo "
    <div class=\"header-bottom ";
        // line 5
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["sticky_menu"]) ? $context["sticky_menu"] : null), "html", null, true));
        echo "\">
      <div class=\"main-menu\">
        <div class=\"container\">
           <div class=\"row\">
              <div class=\"col-xs-12 area-main-menu\">
                <div class=\"area-inner menu-hover\">
                  ";
        // line 11
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "main_menu", array())) {
            // line 12
            echo "                    ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "main_menu", array()), "html", null, true));
            echo "
                  ";
        }
        // line 13
        echo "  
                  <div id=\"menu-bar\" class=\"menu-bar\">
                    <span class=\"one\"></span>
                    <span class=\"two\"></span>
                    <span class=\"three\"></span>
                  </div>
                </div>   
              </div>
           </div>
        </div>
      </div>
    </div>

    <div class=\"branding-main text-center\">
      <div class=\"container\">
        ";
        // line 28
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "branding", array())) {
            // line 29
            echo "          ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "branding", array()), "html", null, true));
            echo "
        ";
        }
        // line 30
        echo "       
      </div>
   </div>
   
</header>
";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/header-3.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 30,  88 => 29,  86 => 28,  69 => 13,  63 => 12,  61 => 11,  52 => 5,  49 => 4,  47 => 3,  43 => 1,);
    }
}
/* <header id="header" class="header-v3">*/
/*   */
/*   {% include directory ~ '/templates/page/parts/topbar.html.twig' %}*/
/* */
/*     <div class="header-bottom {{sticky_menu}}">*/
/*       <div class="main-menu">*/
/*         <div class="container">*/
/*            <div class="row">*/
/*               <div class="col-xs-12 area-main-menu">*/
/*                 <div class="area-inner menu-hover">*/
/*                   {% if page.main_menu %}*/
/*                     {{ page.main_menu }}*/
/*                   {% endif %}  */
/*                   <div id="menu-bar" class="menu-bar">*/
/*                     <span class="one"></span>*/
/*                     <span class="two"></span>*/
/*                     <span class="three"></span>*/
/*                   </div>*/
/*                 </div>   */
/*               </div>*/
/*            </div>*/
/*         </div>*/
/*       </div>*/
/*     </div>*/
/* */
/*     <div class="branding-main text-center">*/
/*       <div class="container">*/
/*         {% if page.branding %}*/
/*           {{ page.branding }}*/
/*         {% endif %}       */
/*       </div>*/
/*    </div>*/
/*    */
/* </header>*/
/* */
