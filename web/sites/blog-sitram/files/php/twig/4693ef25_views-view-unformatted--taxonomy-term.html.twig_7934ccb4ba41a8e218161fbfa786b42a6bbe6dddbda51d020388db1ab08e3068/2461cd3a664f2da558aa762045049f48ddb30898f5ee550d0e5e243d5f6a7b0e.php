<?php

/* themes/gavias_great/templates/views/term/views-view-unformatted--taxonomy-term.html.twig */
class __TwigTemplate_c5e0cad3f7952fefe03b0677d4429b2ded1e38ee53b44e2946507ee315cdfc58 extends Twig_Template
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
        $tags = array("if" => 20, "set" => 24, "for" => 31);
        $filters = array("length" => 49);
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

        // line 20
        if ((isset($context["title"]) ? $context["title"] : null)) {
            // line 21
            echo "  <h3>";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
            echo "</h3>
";
        }
        // line 23
        echo "
";
        // line 24
        $context["i"] = 0;
        // line 25
        echo "<div class=\"categories-view-content view-content-wrap layout-";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["gva_layout"]) ? $context["gva_layout"] : null), "html", null, true));
        echo "\">
  
  ";
        // line 27
        if (((isset($context["gva_layout"]) ? $context["gva_layout"] : null) == "masonry")) {
            // line 28
            echo "    <div class=\"post-masonry-style row\">
  ";
        }
        // line 29
        echo "  

    ";
        // line 31
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["rows"]) ? $context["rows"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 32
            echo "      
      ";
            // line 33
            $context["i"] = ((isset($context["i"]) ? $context["i"] : null) + 1);
            // line 34
            echo "       ";
            // line 35
            $context["row_classes"] = array(0 => ((            // line 36
(isset($context["default_row_class"]) ? $context["default_row_class"] : null)) ? ("item") : ("")), 1 =>             // line 37
(isset($context["gva_item_class"]) ? $context["gva_item_class"] : null));
            // line 40
            echo "
      ";
            // line 41
            if (((((isset($context["gva_layout"]) ? $context["gva_layout"] : null) == "grid") || ((isset($context["gva_layout"]) ? $context["gva_layout"] : null) == "small")) && (((isset($context["i"]) ? $context["i"] : null) % (isset($context["gva_columns"]) ? $context["gva_columns"] : null)) == 1))) {
                echo " 
        <div class=\"row\">
      ";
            }
            // line 43
            echo " 
      
        <div";
            // line 45
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($this->getAttribute($context["row"], "attributes", array()), "addClass", array(0 => (isset($context["row_classes"]) ? $context["row_classes"] : null)), "method"), "html", null, true));
            echo ">
          ";
            // line 46
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["row"], "content", array()), "html", null, true));
            echo "
        </div>
     
      ";
            // line 49
            if (((((isset($context["gva_layout"]) ? $context["gva_layout"] : null) == "grid") || ((isset($context["gva_layout"]) ? $context["gva_layout"] : null) == "small")) && ((((isset($context["i"]) ? $context["i"] : null) % (isset($context["gva_columns"]) ? $context["gva_columns"] : null)) == 0) || ((isset($context["i"]) ? $context["i"] : null) == twig_length_filter($this->env, (isset($context["rows"]) ? $context["rows"] : null)))))) {
                echo " 
        </div>
      ";
            }
            // line 51
            echo " 

    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        echo "
  ";
        // line 55
        if (((isset($context["gva_layout"]) ? $context["gva_layout"] : null) == "masonry")) {
            // line 56
            echo "    </div>
  ";
        }
        // line 57
        echo " 
   
</div>
";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/views/term/views-view-unformatted--taxonomy-term.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  133 => 57,  129 => 56,  127 => 55,  124 => 54,  116 => 51,  110 => 49,  104 => 46,  100 => 45,  96 => 43,  90 => 41,  87 => 40,  85 => 37,  84 => 36,  83 => 35,  81 => 34,  79 => 33,  76 => 32,  72 => 31,  68 => 29,  64 => 28,  62 => 27,  56 => 25,  54 => 24,  51 => 23,  45 => 21,  43 => 20,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Default theme implementation to display a view of unformatted rows.*/
/*  **/
/*  * Available variables:*/
/*  * - title: The title of this group of rows. May be empty.*/
/*  * - rows: A list of the view's row items.*/
/*  *   - attributes: The row's HTML attributes.*/
/*  *   - content: The row's content.*/
/*  * - view: The view object.*/
/*  * - default_row_class: A flag indicating whether default classes should be*/
/*  *   used on rows.*/
/*  **/
/*  * @see template_preprocess_views_view_unformatted()*/
/*  **/
/*  * @ingroup themeable*/
/*  *//* */
/* #}*/
/* {% if title %}*/
/*   <h3>{{ title }}</h3>*/
/* {% endif %}*/
/* */
/* {% set i = 0 %}*/
/* <div class="categories-view-content view-content-wrap layout-{{ gva_layout }}">*/
/*   */
/*   {% if gva_layout == 'masonry' %}*/
/*     <div class="post-masonry-style row">*/
/*   {% endif %}  */
/* */
/*     {% for row in rows %}*/
/*       */
/*       {% set i = i + 1 %}*/
/*        {%*/
/*          set row_classes = [*/
/*            default_row_class ? 'item',*/
/*            gva_item_class*/
/*          ]*/
/*        %}*/
/* */
/*       {% if (gva_layout == 'grid' or gva_layout == 'small') and i % gva_columns  == 1 %} */
/*         <div class="row">*/
/*       {% endif %} */
/*       */
/*         <div{{ row.attributes.addClass(row_classes) }}>*/
/*           {{ row.content }}*/
/*         </div>*/
/*      */
/*       {% if (gva_layout == 'grid' or gva_layout == 'small') and ( i % gva_columns == 0 or i == rows|length ) %} */
/*         </div>*/
/*       {% endif %} */
/* */
/*     {% endfor %}*/
/* */
/*   {% if gva_layout == 'masonry' %}*/
/*     </div>*/
/*   {% endif %} */
/*    */
/* </div>*/
/* */
