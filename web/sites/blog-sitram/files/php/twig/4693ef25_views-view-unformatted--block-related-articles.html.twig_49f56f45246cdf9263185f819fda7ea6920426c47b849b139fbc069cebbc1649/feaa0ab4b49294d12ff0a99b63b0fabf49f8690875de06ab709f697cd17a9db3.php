<?php

/* themes/gavias_great/templates/views/article/views-view-unformatted--block-related-articles.html.twig */
class __TwigTemplate_eda65e3dea225ff73beaf27944311b127efd61b5308250451f86c74387adbbc7 extends Twig_Template
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
        $tags = array("if" => 2, "set" => 6, "for" => 7);
        $filters = array("length" => 23);
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
        echo "<div>
   ";
        // line 2
        if ((isset($context["title"]) ? $context["title"] : null)) {
            // line 3
            echo "      ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
            echo "
   ";
        }
        // line 5
        echo "   <div class=\"category-2columns\">
      ";
        // line 6
        $context["i"] = 0;
        // line 7
        echo "      ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["rows"]) ? $context["rows"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 8
            echo "         ";
            $context["class_row"] = "";
            // line 9
            echo "         ";
            $context["i"] = ((isset($context["i"]) ? $context["i"] : null) + 1);
            // line 10
            echo "         
         ";
            // line 11
            if (((isset($context["i"]) ? $context["i"] : null) == 1)) {
                // line 12
                echo "            ";
                $context["class_row"] = "row-first";
                // line 13
                echo "         ";
            } else {
                // line 14
                echo "            ";
                $context["class_row"] = "row-second";
                // line 15
                echo "         ";
            }
            echo "  

         ";
            // line 17
            if ((((isset($context["i"]) ? $context["i"] : null) % 2) == 1)) {
                // line 18
                echo "            <div class=\"row ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["class_row"]) ? $context["class_row"] : null), "html", null, true));
                echo "\">
         ";
            }
            // line 19
            echo "   
            <div class=\"col-sm-6 col-xs-12\">
               ";
            // line 21
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["row"], "content", array()), "html", null, true));
            echo "
            </div>
         ";
            // line 23
            if (((((isset($context["i"]) ? $context["i"] : null) % 2) == 0) || ((isset($context["i"]) ? $context["i"] : null) == twig_length_filter($this->env, (isset($context["rows"]) ? $context["rows"] : null))))) {
                // line 24
                echo "            </div>
         ";
            }
            // line 25
            echo "   

      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "   
   </div>
</div>";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/views/article/views-view-unformatted--block-related-articles.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  121 => 27,  113 => 25,  109 => 24,  107 => 23,  102 => 21,  98 => 19,  92 => 18,  90 => 17,  84 => 15,  81 => 14,  78 => 13,  75 => 12,  73 => 11,  70 => 10,  67 => 9,  64 => 8,  59 => 7,  57 => 6,  54 => 5,  48 => 3,  46 => 2,  43 => 1,);
    }
}
/* <div>*/
/*    {% if title %}*/
/*       {{ title }}*/
/*    {% endif %}*/
/*    <div class="category-2columns">*/
/*       {% set i = 0 %}*/
/*       {% for row in rows %}*/
/*          {% set class_row = "" %}*/
/*          {% set i = i + 1 %}*/
/*          */
/*          {% if i == 1 %}*/
/*             {% set class_row = "row-first" %}*/
/*          {% else %}*/
/*             {% set class_row = "row-second" %}*/
/*          {% endif %}  */
/* */
/*          {% if i % 2 == 1 %}*/
/*             <div class="row {{class_row}}">*/
/*          {% endif %}   */
/*             <div class="col-sm-6 col-xs-12">*/
/*                {{ row.content }}*/
/*             </div>*/
/*          {% if i % 2 == 0 or i == rows|length %}*/
/*             </div>*/
/*          {% endif %}   */
/* */
/*       {% endfor %}   */
/*    </div>*/
/* </div>*/
