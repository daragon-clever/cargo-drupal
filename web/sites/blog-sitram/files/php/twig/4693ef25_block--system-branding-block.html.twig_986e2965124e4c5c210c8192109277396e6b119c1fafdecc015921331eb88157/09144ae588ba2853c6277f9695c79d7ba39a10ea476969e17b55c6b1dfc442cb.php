<?php

/* themes/gavias_great/templates/block/block--system-branding-block.html.twig */
class __TwigTemplate_158b9d3b0b665176345e82f93486978d81e39d2b45b05ffc895bbc4fbe4be0c8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("block.html.twig", "themes/gavias_great/templates/block/block--system-branding-block.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "block.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array("set" => 17, "if" => 19);
        $filters = array("t" => 20, "replace" => 22);
        $functions = array("path" => 20);

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set', 'if'),
                array('t', 'replace'),
                array('path')
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

        // line 17
        $context["attributes"] = $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => "site-branding"), "method");
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 18
    public function block_content($context, array $blocks = array())
    {
        // line 19
        echo "  ";
        if ((isset($context["site_logo"]) ? $context["site_logo"] : null)) {
            // line 20
            echo "    <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar($this->env->getExtension('drupal_core')->getPath("<front>")));
            echo "\" title=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Home")));
            echo "\" rel=\"home\" class=\"site-branding-logo padding-top-20\">
      ";
            // line 21
            if ((isset($context["setting_logo"]) ? $context["setting_logo"] : null)) {
                // line 22
                echo "         <img src=\"";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, twig_replace_filter((isset($context["site_logo"]) ? $context["site_logo"] : null), array(".svg" => ".png")), "html", null, true));
                echo "\" alt=\"";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Home")));
                echo "\" />
      ";
            } else {
                // line 23
                echo "  
        <img src=\"";
                // line 24
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["site_logo"]) ? $context["site_logo"] : null), "html", null, true));
                echo "\" alt=\"";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Home")));
                echo "\" />
      ";
            }
            // line 25
            echo "  
    </a>
  ";
        }
        // line 28
        echo "  ";
        if (((isset($context["site_name"]) ? $context["site_name"] : null) || (isset($context["site_slogan"]) ? $context["site_slogan"] : null))) {
            // line 29
            echo "    <div class=\"site-branding__text\">
      ";
            // line 30
            if ((isset($context["site_name"]) ? $context["site_name"] : null)) {
                // line 31
                echo "        <div class=\"site-branding__name\">
          <a href=\"";
                // line 32
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar($this->env->getExtension('drupal_core')->getPath("<front>")));
                echo "\" title=\"";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Home")));
                echo "\" rel=\"home\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["site_name"]) ? $context["site_name"] : null), "html", null, true));
                echo "</a>
        </div>
      ";
            }
            // line 35
            echo "      ";
            if ((isset($context["site_slogan"]) ? $context["site_slogan"] : null)) {
                // line 36
                echo "        <div class=\"site-branding__slogan\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["site_slogan"]) ? $context["site_slogan"] : null), "html", null, true));
                echo "</div>
      ";
            }
            // line 38
            echo "    </div>
  ";
        }
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/block/block--system-branding-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  123 => 38,  117 => 36,  114 => 35,  104 => 32,  101 => 31,  99 => 30,  96 => 29,  93 => 28,  88 => 25,  81 => 24,  78 => 23,  70 => 22,  68 => 21,  61 => 20,  58 => 19,  55 => 18,  51 => 1,  49 => 17,  11 => 1,);
    }
}
/* {% extends "block.html.twig" %}*/
/* {#*/
/* /***/
/*  * @file*/
/*  * Bartik's theme implementation for a branding block.*/
/*  **/
/*  * Each branding element variable (logo, name, slogan) is only available if*/
/*  * enabled in the block configuration.*/
/*  **/
/*  * Available variables:*/
/*  * - site_logo: Logo for site as defined in Appearance or theme settings.*/
/*  * - site_name: Name for site as defined in Site information settings.*/
/*  * - site_slogan: Slogan for site as defined in Site information settings.*/
/*  *//* */
/* #}*/
/* */
/* {% set attributes = attributes.addClass('site-branding') %}*/
/* {% block content %}*/
/*   {% if site_logo %}*/
/*     <a href="{{ path('<front>') }}" title="{{ 'Home'|t }}" rel="home" class="site-branding-logo padding-top-20">*/
/*       {% if setting_logo %}*/
/*          <img src="{{ site_logo|replace({'.svg': '.png'}) }}" alt="{{ 'Home'|t }}" />*/
/*       {% else %}  */
/*         <img src="{{ site_logo }}" alt="{{ 'Home'|t }}" />*/
/*       {% endif %}  */
/*     </a>*/
/*   {% endif %}*/
/*   {% if site_name or site_slogan %}*/
/*     <div class="site-branding__text">*/
/*       {% if site_name %}*/
/*         <div class="site-branding__name">*/
/*           <a href="{{ path('<front>') }}" title="{{ 'Home'|t }}" rel="home">{{ site_name }}</a>*/
/*         </div>*/
/*       {% endif %}*/
/*       {% if site_slogan %}*/
/*         <div class="site-branding__slogan">{{ site_slogan }}</div>*/
/*       {% endif %}*/
/*     </div>*/
/*   {% endif %}*/
/* {% endblock %}*/
/* */
