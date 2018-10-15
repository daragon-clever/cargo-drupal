<?php

/* {# inline_template_start #}<div class="post-block">
      <div class="post-content"> 
              <div class="number">0{{ counter }}</div>
             <div class="post-title"> {{ title }} </div>
       </div>
</div> */
class __TwigTemplate_431c1489c56f6f60d45f24c470665617c070e80fe81fe58b1a32b8173bdeb4e5 extends Twig_Template
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
        $tags = array();
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array(),
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
        echo "<div class=\"post-block\">
      <div class=\"post-content\"> 
              <div class=\"number\">0";
        // line 3
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["counter"]) ? $context["counter"] : null), "html", null, true));
        echo "</div>
             <div class=\"post-title\"> ";
        // line 4
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
        echo " </div>
       </div>
</div>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<div class=\"post-block\">
      <div class=\"post-content\"> 
              <div class=\"number\">0{{ counter }}</div>
             <div class=\"post-title\"> {{ title }} </div>
       </div>
</div>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 4,  52 => 3,  48 => 1,);
    }
}
/* {# inline_template_start #}<div class="post-block">*/
/*       <div class="post-content"> */
/*               <div class="number">0{{ counter }}</div>*/
/*              <div class="post-title"> {{ title }} </div>*/
/*        </div>*/
/* </div>*/
