<?php

/* themes/gavias_great/templates/navigation/breadcrumb.html.twig */
class __TwigTemplate_c1603c615d33708ec0f9e3fb24107b6ea597a3a20080b0ba0e675ed67a326c82 extends Twig_Template
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
        $tags = array("if" => 10, "set" => 14, "for" => 15);
        $filters = array("t" => 12, "length" => 23);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if', 'set', 'for'),
                array('t', 'length'),
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

        // line 10
        if ((isset($context["breadcrumb"]) ? $context["breadcrumb"] : null)) {
            // line 11
            echo "  <nav class=\"breadcrumb\" role=\"navigation\">
    <h2 id=\"system-breadcrumb\" class=\"visually-hidden\">";
            // line 12
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Breadcrumb")));
            echo "</h2>
    <ol>
    ";
            // line 14
            $context["i"] = 0;
            echo "  
    ";
            // line 15
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["breadcrumb"]) ? $context["breadcrumb"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 16
                echo "      ";
                $context["i"] = ((isset($context["i"]) ? $context["i"] : null) + 1);
                // line 17
                echo "      <li>
        ";
                // line 18
                if ($this->getAttribute($context["item"], "url", array())) {
                    // line 19
                    echo "          <a href=\"";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "url", array()), "html", null, true));
                    echo "\">";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "text", array()), "html", null, true));
                    echo "</a>
        ";
                } else {
                    // line 21
                    echo "          ";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["item"], "text", array()), "html", null, true));
                    echo "
        ";
                }
                // line 23
                echo "        ";
                if (((isset($context["i"]) ? $context["i"] : null) < (twig_length_filter($this->env, (isset($context["breadcrumb"]) ? $context["breadcrumb"] : null)) - 1))) {
                    // line 24
                    echo "          <span class=\"\"> - </span>
        ";
                }
                // line 25
                echo "  
      </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 28
            echo "
      <li></li>
    </ol>
  </nav>
";
        }
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/navigation/breadcrumb.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 28,  90 => 25,  86 => 24,  83 => 23,  77 => 21,  69 => 19,  67 => 18,  64 => 17,  61 => 16,  57 => 15,  53 => 14,  48 => 12,  45 => 11,  43 => 10,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Theme override for a breadcrumb trail.*/
/*  **/
/*  * Available variables:*/
/*  * - breadcrumb: Breadcrumb trail items.*/
/*  *//* */
/* #}*/
/* {% if breadcrumb %}*/
/*   <nav class="breadcrumb" role="navigation">*/
/*     <h2 id="system-breadcrumb" class="visually-hidden">{{ 'Breadcrumb'|t }}</h2>*/
/*     <ol>*/
/*     {% set i = 0 %}  */
/*     {% for item in breadcrumb %}*/
/*       {% set i = i + 1 %}*/
/*       <li>*/
/*         {% if item.url %}*/
/*           <a href="{{ item.url }}">{{ item.text }}</a>*/
/*         {% else %}*/
/*           {{ item.text }}*/
/*         {% endif %}*/
/*         {% if i < breadcrumb|length - 1 %}*/
/*           <span class=""> - </span>*/
/*         {% endif %}  */
/*       </li>*/
/*     {% endfor %}*/
/* */
/*       <li></li>*/
/*     </ol>*/
/*   </nav>*/
/* {% endif %}*/
/* */
