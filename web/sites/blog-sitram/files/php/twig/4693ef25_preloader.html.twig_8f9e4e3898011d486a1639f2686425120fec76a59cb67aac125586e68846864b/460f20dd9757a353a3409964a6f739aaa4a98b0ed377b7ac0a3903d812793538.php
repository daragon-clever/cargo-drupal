<?php

/* themes/gavias_great/templates/page/parts/preloader.html.twig */
class __TwigTemplate_d88bda595afddc627e65ce8f4faaf819ac3a0c88d3376bcc3728067ea4c200b1 extends Twig_Template
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
        echo "   ";
        if (((isset($context["preloader"]) ? $context["preloader"] : null) == 1)) {
            // line 2
            echo "     <div id=\"jpreContent\" >
         <div id=\"jprecontent-inner\">
            <div class=\"preloader-wrapper active\">
               <img src=\"";
            // line 5
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["theme_path"]) ? $context["theme_path"] : null), "html", null, true));
            echo "/images/preloader/preloader-10.gif\" alt=\"\" />
            </div>  
         </div>
       </div>
   ";
        }
        // line 9
        echo " ";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/parts/preloader.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 9,  51 => 5,  46 => 2,  43 => 1,);
    }
}
/*    {% if preloader == 1 %}*/
/*      <div id="jpreContent" >*/
/*          <div id="jprecontent-inner">*/
/*             <div class="preloader-wrapper active">*/
/*                <img src="{{ theme_path }}/images/preloader/preloader-10.gif" alt="" />*/
/*             </div>  */
/*          </div>*/
/*        </div>*/
/*    {% endif %} */
