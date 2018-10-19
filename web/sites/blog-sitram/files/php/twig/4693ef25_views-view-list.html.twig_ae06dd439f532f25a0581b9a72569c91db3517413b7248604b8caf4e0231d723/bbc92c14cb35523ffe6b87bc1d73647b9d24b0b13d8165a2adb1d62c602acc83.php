<?php

/* themes/gavias_great/templates/views/views-view-list.html.twig */
class __TwigTemplate_500b4bbbdbce2352664f35d3a654a80e7c40dcdd70aa51469d11cbd8746d60e5 extends Twig_Template
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
        $tags = array("if" => 21, "for" => 28);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if', 'for'),
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

        // line 21
        if ((isset($context["attributes"]) ? $context["attributes"] : null)) {
            // line 22
            echo "<div";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["attributes"]) ? $context["attributes"] : null), "html", null, true));
            echo ">
";
        }
        // line 24
        echo "  ";
        if ((isset($context["title"]) ? $context["title"] : null)) {
            // line 25
            echo "    <h3>";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
            echo "</h3>
  ";
        }
        // line 27
        echo "  <";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["list"]) ? $context["list"] : null), "type", array()), "html", null, true));
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["list"]) ? $context["list"] : null), "attributes", array()), "html", null, true));
        echo ">
    ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["rows"]) ? $context["rows"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 29
            echo "      <li class=\"view-list-item\" ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["row"], "attributes", array()), "html", null, true));
            echo ">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["row"], "content", array()), "html", null, true));
            echo "</li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "  </";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["list"]) ? $context["list"] : null), "type", array()), "html", null, true));
        echo ">
";
        // line 32
        if ((isset($context["attributes"]) ? $context["attributes"] : null)) {
            // line 33
            echo "</div>
";
        }
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/views/views-view-list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 33,  86 => 32,  81 => 31,  70 => 29,  66 => 28,  60 => 27,  54 => 25,  51 => 24,  45 => 22,  43 => 21,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Default theme implementation for a view template to display a list of rows.*/
/*  **/
/*  * Available variables:*/
/*  * - attributes: HTML attributes for the container.*/
/*  * - rows: A list of rows for this list.*/
/*  *   - attributes: The row's HTML attributes.*/
/*  *   - content: The row's contents.*/
/*  * - title: The title of this group of rows. May be empty.*/
/*  * - list: @todo.*/
/*  *   - type: Starting tag will be either a ul or ol.*/
/*  *   - attributes: HTML attributes for the list element.*/
/*  **/
/*  * @see template_preprocess_views_view_list()*/
/*  **/
/*  * @ingroup themeable*/
/*  *//* */
/* #}*/
/* {% if attributes -%}*/
/*   <div{{ attributes }}>*/
/* {% endif %}*/
/*   {% if title %}*/
/*     <h3>{{ title }}</h3>*/
/*   {% endif %}*/
/*   <{{ list.type }}{{ list.attributes }}>*/
/*     {% for row in rows %}*/
/*       <li class="view-list-item" {{ row.attributes }}>{{ row.content }}</li>*/
/*     {% endfor %}*/
/*   </{{ list.type }}>*/
/* {% if attributes -%}*/
/*   </div>*/
/* {% endif %}*/
/* */
