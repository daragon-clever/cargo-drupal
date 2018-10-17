<?php

/* {# inline_template_start #}<div class="post-category {{ field_taxonomy_color }}"><span>{{ field_post_category }}</span></div> */
class __TwigTemplate_f518308145fe5f306dc7f28125b6d57f762f6d6dd7939671e5c5d03851105fa7 extends Twig_Template
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
        echo "<div class=\"post-category ";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_taxonomy_color"]) ? $context["field_taxonomy_color"] : null), "html", null, true));
        echo "\"><span>";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_post_category"]) ? $context["field_post_category"] : null), "html", null, true));
        echo "</span></div>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<div class=\"post-category {{ field_taxonomy_color }}\"><span>{{ field_post_category }}</span></div>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }
}
/* {# inline_template_start #}<div class="post-category {{ field_taxonomy_color }}"><span>{{ field_post_category }}</span></div>*/
