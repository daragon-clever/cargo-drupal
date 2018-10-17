<?php

/* themes/gavias_great/templates/page/header.html.twig */
class __TwigTemplate_d9b6509d2e570716e02d8ee77c3c8a25f93cb00f2028435cfcef215b947f7068 extends Twig_Template
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
        $tags = array("include" => 3, "if" => 10);
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
        echo "<header id=\"header\" class=\"header-v1\">
  
  ";
        // line 3
        $this->loadTemplate(((isset($context["directory"]) ? $context["directory"] : null) . "/templates/page/parts/topbar.html.twig"), "themes/gavias_great/templates/page/header.html.twig", 3)->display($context);
        // line 4
        echo "
   <div class=\"header-main\">
      <div class=\"container\">
         <div class=\"header-main-inner\">
            <div class=\"row\">
               <div class=\"col-md-4 col-xs-12\">
               ";
        // line 10
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "branding", array())) {
            // line 11
            echo "                  ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "branding", array()), "html", null, true));
            echo "
               ";
        }
        // line 13
        echo "               </div>

               <div class=\"col-md-8 col-xs-12 header-right\">
                  ";
        // line 16
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "header_right", array())) {
            // line 17
            echo "                     <div class=\"header-right-inner\">
                        ";
            // line 18
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "header_right", array()), "html", null, true));
            echo "
                     </div>
                   ";
        }
        // line 21
        echo "               </div>
            </div>
         </div>
      </div>
   </div>

    <div class=\"header-bottom ";
        // line 27
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["sticky_menu"]) ? $context["sticky_menu"] : null), "html", null, true));
        echo "\">
      <div class=\"main-menu\">
        <div class=\"container\">
           <div class=\"row\">
              <div class=\"col-xs-12 area-main-menu\">
                <div class=\"area-inner menu-hover\">
                  ";
        // line 33
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "main_menu", array())) {
            // line 34
            echo "                    ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "main_menu", array()), "html", null, true));
            echo "
                  ";
        }
        // line 35
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
   
</header>
";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 35,  100 => 34,  98 => 33,  89 => 27,  81 => 21,  75 => 18,  72 => 17,  70 => 16,  65 => 13,  59 => 11,  57 => 10,  49 => 4,  47 => 3,  43 => 1,);
    }
}
/* <header id="header" class="header-v1">*/
/*   */
/*   {% include directory ~ '/templates/page/parts/topbar.html.twig' %}*/
/* */
/*    <div class="header-main">*/
/*       <div class="container">*/
/*          <div class="header-main-inner">*/
/*             <div class="row">*/
/*                <div class="col-md-4 col-xs-12">*/
/*                {% if page.branding %}*/
/*                   {{ page.branding }}*/
/*                {% endif %}*/
/*                </div>*/
/* */
/*                <div class="col-md-8 col-xs-12 header-right">*/
/*                   {% if page.header_right %}*/
/*                      <div class="header-right-inner">*/
/*                         {{ page.header_right }}*/
/*                      </div>*/
/*                    {% endif %}*/
/*                </div>*/
/*             </div>*/
/*          </div>*/
/*       </div>*/
/*    </div>*/
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
/*    </div>*/
/*    */
/* </header>*/
/* */
