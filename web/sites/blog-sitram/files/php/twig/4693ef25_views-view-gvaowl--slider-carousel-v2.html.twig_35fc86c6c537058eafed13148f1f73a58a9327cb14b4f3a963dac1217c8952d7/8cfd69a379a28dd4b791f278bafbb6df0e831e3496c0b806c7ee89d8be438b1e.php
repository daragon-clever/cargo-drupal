<?php

/* themes/gavias_great/templates/views/slideshows/views-view-gvaowl--slider-carousel-v2.html.twig */
class __TwigTemplate_a476b0e90120da5fd275249ae2538865d3ff50770b68c519a4ee20538dce855f extends Twig_Template
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
        $tags = array("if" => 1, "set" => 5, "for" => 6);
        $filters = array("length" => 19);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if', 'set', 'for'),
                array('length'),
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
        if ((isset($context["attributes"]) ? $context["attributes"] : null)) {
            // line 2
            echo "<div";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => "slider-posts v2"), "method"), "html", null, true));
            echo ">
";
        }
        // line 4
        echo "
   ";
        // line 5
        $context["i"] = 0;
        // line 6
        echo "   ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["rows"]) ? $context["rows"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 7
            echo "      ";
            $context["i"] = ((isset($context["i"]) ? $context["i"] : null) + 1);
            // line 8
            echo "      ";
            if ((((isset($context["i"]) ? $context["i"] : null) % 3) == 1)) {
                echo "<div class=\"item\"><div class=\"row\">";
            }
            // line 9
            echo "         ";
            if ((((isset($context["i"]) ? $context["i"] : null) % 3) == 1)) {
                // line 10
                echo "            <div class=\"post-large post-item col-sm-8 col-xs-12\">
               <div class=\"item content\">";
                // line 11
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["row"], "content", array()), "html", null, true));
                echo "</div>
            </div>
         ";
            }
            // line 13
            echo "   
         ";
            // line 14
            if (((((isset($context["i"]) ? $context["i"] : null) % 3) == 2) || (((isset($context["i"]) ? $context["i"] : null) % 3) == 0))) {
                // line 15
                echo "            ";
                if ((((isset($context["i"]) ? $context["i"] : null) % 3) == 2)) {
                    // line 16
                    echo "               <div class=\"post-small post-item col-sm-4 col-xs-12\">
            ";
                }
                // line 18
                echo "               <div class=\"item content post-small-item\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["row"], "content", array()), "html", null, true));
                echo "</div>
            ";
                // line 19
                if (((((isset($context["i"]) ? $context["i"] : null) % 3) == 0) || ((isset($context["i"]) ? $context["i"] : null) == twig_length_filter($this->env, (isset($context["rows"]) ? $context["rows"] : null))))) {
                    // line 20
                    echo "               </div>
            ";
                }
                // line 21
                echo "      
         ";
            }
            // line 22
            echo "  
      ";
            // line 23
            if (((((isset($context["i"]) ? $context["i"] : null) % 3) == 0) || ((isset($context["i"]) ? $context["i"] : null) == twig_length_filter($this->env, (isset($context["rows"]) ? $context["rows"] : null))))) {
                echo "</div></div>";
            }
            // line 24
            echo "   ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo "   

";
        // line 26
        if ((isset($context["attributes"]) ? $context["attributes"] : null)) {
            // line 27
            echo "</div>
";
        }
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/views/slideshows/views-view-gvaowl--slider-carousel-v2.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 27,  124 => 26,  115 => 24,  111 => 23,  108 => 22,  104 => 21,  100 => 20,  98 => 19,  93 => 18,  89 => 16,  86 => 15,  84 => 14,  81 => 13,  75 => 11,  72 => 10,  69 => 9,  64 => 8,  61 => 7,  56 => 6,  54 => 5,  51 => 4,  45 => 2,  43 => 1,);
    }
}
/* {% if attributes -%}*/
/*    <div{{ attributes.addClass('slider-posts v2') }}>*/
/* {% endif %}*/
/* */
/*    {% set i = 0 %}*/
/*    {% for row in rows %}*/
/*       {% set i = i + 1 %}*/
/*       {% if i % 3 == 1 %}<div class="item"><div class="row">{% endif %}*/
/*          {% if i % 3 == 1 %}*/
/*             <div class="post-large post-item col-sm-8 col-xs-12">*/
/*                <div class="item content">{{ row.content }}</div>*/
/*             </div>*/
/*          {% endif %}   */
/*          {% if i % 3 == 2 or i % 3 == 0 %}*/
/*             {% if i % 3 == 2 %}*/
/*                <div class="post-small post-item col-sm-4 col-xs-12">*/
/*             {% endif %}*/
/*                <div class="item content post-small-item">{{ row.content }}</div>*/
/*             {% if i % 3 == 0 or i == rows|length %}*/
/*                </div>*/
/*             {% endif %}      */
/*          {% endif %}  */
/*       {% if i % 3 == 0 or i == rows|length %}</div></div>{% endif %}*/
/*    {% endfor %}   */
/* */
/* {% if attributes -%}*/
/*     </div>*/
/* {% endif %}*/
/* */
