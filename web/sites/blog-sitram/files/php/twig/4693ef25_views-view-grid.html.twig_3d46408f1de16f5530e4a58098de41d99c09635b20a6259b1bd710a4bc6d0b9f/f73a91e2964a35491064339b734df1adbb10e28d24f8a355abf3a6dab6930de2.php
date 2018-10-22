<?php

/* themes/gavias_great/templates/views/views-view-grid.html.twig */
class __TwigTemplate_97af3e01e49d0b9a5fc9bc505ee59ea91c987d04d38b885dc3d740727f9903c4 extends Twig_Template
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
        $tags = array("set" => 30, "if" => 39, "for" => 74);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set', 'if', 'for'),
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

        // line 30
        $context["classes"] = array(0 => "views-view-grid", 1 => $this->getAttribute(        // line 32
(isset($context["gva_masonry"]) ? $context["gva_masonry"] : null), "class", array()), 2 => $this->getAttribute(        // line 33
(isset($context["options"]) ? $context["options"] : null), "alignment", array()), 3 => ("cols-" . $this->getAttribute(        // line 34
(isset($context["options"]) ? $context["options"] : null), "columns", array())), 4 => "clearfix");
        // line 38
        echo "
  ";
        // line 39
        if (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "columns", array()) == "1")) {
            // line 40
            echo "    ";
            $context["xclass"] = array(0 => "col-lg-12 col-md-12 col-sm-12 col-xs-12");
            // line 41
            echo "  ";
        } elseif (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "columns", array()) == "2")) {
            // line 42
            echo "    ";
            $context["xclass"] = array(0 => "col-lg-6 col-md-6 col-sm-6 col-xs-12");
            // line 43
            echo "  ";
        } elseif (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "columns", array()) == "3")) {
            // line 44
            echo "    ";
            $context["xclass"] = array(0 => "col-lg-4 col-md-4 col-sm-4 col-xs-12");
            // line 45
            echo "  ";
        } elseif (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "columns", array()) == "4")) {
            // line 46
            echo "    ";
            $context["xclass"] = array(0 => "col-lg-3 col-md-3 col-sm-6 col-xs-12");
            // line 47
            echo "  ";
        } elseif (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "columns", array()) == "6")) {
            // line 48
            echo "    ";
            $context["xclass"] = array(0 => "col-lg-2 col-md-2 col-sm-6 col-xs-12");
            // line 49
            echo "  ";
        } else {
            // line 50
            echo "    ";
            $context["xclass"] = array(0 => "col-lg-4 col-md-4 col-sm-4 col-xs-12");
            // line 51
            echo "  ";
        }
        echo "    

";
        // line 53
        if ($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "row_class_default", array())) {
            // line 54
            echo "  ";
            // line 55
            $context["row_classes"] = array(0 => "views-row row", 1 => ((($this->getAttribute(            // line 57
(isset($context["options"]) ? $context["options"] : null), "alignment", array()) == "horizontal")) ? ("clearfix") : ("")));
        }
        // line 61
        if ($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "col_class_default", array())) {
            // line 62
            echo "  ";
            // line 63
            $context["col_classes"] = array(0 => "views-col", 1 => ((($this->getAttribute(            // line 65
(isset($context["options"]) ? $context["options"] : null), "alignment", array()) == "vertical")) ? ("clearfix") : ("")));
        }
        // line 69
        if ((isset($context["title"]) ? $context["title"] : null)) {
            // line 70
            echo "  <h3>";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
            echo "</h3>
";
        }
        // line 72
        echo "<div";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => (isset($context["classes"]) ? $context["classes"] : null)), "method"), "html", null, true));
        echo ">
  ";
        // line 73
        if (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "alignment", array()) == "horizontal")) {
            // line 74
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
            $context['loop'] = array(
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            );
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 75
                echo "      
      ";
                // line 76
                if (($this->getAttribute((isset($context["gva_masonry"]) ? $context["gva_masonry"] : null), "class", array()) == "")) {
                    // line 77
                    echo "        <div";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($this->getAttribute($context["row"], "attributes", array()), "addClass", array(0 => (isset($context["row_classes"]) ? $context["row_classes"] : null), 1 => (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "row_class_default", array())) ? (("row-" . $this->getAttribute($context["loop"], "index", array()))) : (""))), "method"), "html", null, true));
                    echo ">
      ";
                }
                // line 78
                echo "  

        ";
                // line 80
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["row"], "content", array()));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
                    // line 81
                    echo "          <div";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($this->getAttribute($context["column"], "attributes", array()), "addClass", array(0 => (isset($context["col_classes"]) ? $context["col_classes"] : null), 1 => (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "col_class_default", array())) ? (("col-" . $this->getAttribute($context["loop"], "index", array()))) : ("")), 2 => (isset($context["xclass"]) ? $context["xclass"] : null), 3 => $this->getAttribute((isset($context["gva_masonry"]) ? $context["gva_masonry"] : null), "class_item", array())), "method"), "html", null, true));
                    echo ">
            ";
                    // line 82
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["column"], "content", array()), "html", null, true));
                    echo "
          </div>
        ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 85
                echo "      
      ";
                // line 86
                if (($this->getAttribute((isset($context["gva_masonry"]) ? $context["gva_masonry"] : null), "class", array()) == "")) {
                    // line 87
                    echo "        </div>
      ";
                }
                // line 88
                echo "  
    ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 90
            echo "  ";
        } else {
            // line 91
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
            $context['loop'] = array(
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            );
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
                // line 92
                echo "      <div";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($this->getAttribute($context["column"], "attributes", array()), "addClass", array(0 => (isset($context["col_classes"]) ? $context["col_classes"] : null), 1 => (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "col_class_default", array())) ? (("col-" . $this->getAttribute($context["loop"], "index", array()))) : ("")), 2 => (isset($context["xclass"]) ? $context["xclass"] : null)), "method"), "html", null, true));
                echo ">
        ";
                // line 93
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["column"], "content", array()));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                    // line 94
                    echo "          <div";
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($this->getAttribute($context["row"], "attributes", array()), "addClass", array(0 => (isset($context["row_classes"]) ? $context["row_classes"] : null), 1 => (($this->getAttribute((isset($context["options"]) ? $context["options"] : null), "row_class_default", array())) ? (("row-" . $this->getAttribute($context["loop"], "index", array()))) : (""))), "method"), "html", null, true));
                    echo ">
            ";
                    // line 95
                    echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["row"], "content", array()), "html", null, true));
                    echo "
          </div>
        ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 98
                echo "      </div>
    ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 100
            echo "  ";
        }
        // line 101
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/views/views-view-grid.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  302 => 101,  299 => 100,  284 => 98,  267 => 95,  262 => 94,  245 => 93,  240 => 92,  222 => 91,  219 => 90,  204 => 88,  200 => 87,  198 => 86,  195 => 85,  178 => 82,  173 => 81,  156 => 80,  152 => 78,  146 => 77,  144 => 76,  141 => 75,  123 => 74,  121 => 73,  116 => 72,  110 => 70,  108 => 69,  105 => 65,  104 => 63,  102 => 62,  100 => 61,  97 => 57,  96 => 55,  94 => 54,  92 => 53,  86 => 51,  83 => 50,  80 => 49,  77 => 48,  74 => 47,  71 => 46,  68 => 45,  65 => 44,  62 => 43,  59 => 42,  56 => 41,  53 => 40,  51 => 39,  48 => 38,  46 => 34,  45 => 33,  44 => 32,  43 => 30,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Default theme implementation for views to display rows in a grid.*/
/*  **/
/*  * Available variables:*/
/*  * - attributes: HTML attributes for the wrapping element.*/
/*  * - title: The title of this group of rows.*/
/*  * - view: The view object.*/
/*  * - rows: The rendered view results.*/
/*  * - options: The view plugin style options.*/
/*  *   - row_class_default: A flag indicating whether default classes should be*/
/*  *     used on rows.*/
/*  *   - col_class_default: A flag indicating whether default classes should be*/
/*  *     used on columns.*/
/*  * - items: A list of grid items. Each item contains a list of rows or columns.*/
/*  *   The order in what comes first (row or column) depends on which alignment*/
/*  *   type is chosen (horizontal or vertical).*/
/*  *   - attributes: HTML attributes for each row or column.*/
/*  *   - content: A list of columns or rows. Each row or column contains:*/
/*  *     - attributes: HTML attributes for each row or column.*/
/*  *     - content: The row or column contents.*/
/*  **/
/*  * @see template_preprocess_views_view_grid()*/
/*  **/
/*  * @ingroup themeable*/
/*  *//* */
/* #}*/
/* {%*/
/*   set classes = [*/
/*     'views-view-grid',*/
/*     gva_masonry.class,*/
/*     options.alignment,*/
/*     'cols-' ~ options.columns,*/
/*     'clearfix',*/
/*   ]*/
/* %}*/
/* */
/*   {% if options.columns == '1' %}*/
/*     {% set xclass = ['col-lg-12 col-md-12 col-sm-12 col-xs-12'] %}*/
/*   {% elseif options.columns == '2' %}*/
/*     {% set xclass = ['col-lg-6 col-md-6 col-sm-6 col-xs-12'] %}*/
/*   {% elseif options.columns == '3' %}*/
/*     {% set xclass = ['col-lg-4 col-md-4 col-sm-4 col-xs-12'] %}*/
/*   {% elseif options.columns == '4' %}*/
/*     {% set xclass = ['col-lg-3 col-md-3 col-sm-6 col-xs-12'] %}*/
/*   {% elseif options.columns == '6' %}*/
/*     {% set xclass = ['col-lg-2 col-md-2 col-sm-6 col-xs-12'] %}*/
/*   {% else %}*/
/*     {% set xclass = ['col-lg-4 col-md-4 col-sm-4 col-xs-12'] %}*/
/*   {% endif %}    */
/* */
/* {% if options.row_class_default %}*/
/*   {%*/
/*     set row_classes = [*/
/*       'views-row row',*/
/*       options.alignment == 'horizontal' ? 'clearfix',*/
/*     ]*/
/*   %}*/
/* {% endif %}*/
/* {% if options.col_class_default %}*/
/*   {%*/
/*     set col_classes = [*/
/*       'views-col',*/
/*       options.alignment == 'vertical' ? 'clearfix',*/
/*     ]*/
/*   %}*/
/* {% endif %}*/
/* {% if title %}*/
/*   <h3>{{ title }}</h3>*/
/* {% endif %}*/
/* <div{{ attributes.addClass(classes) }}>*/
/*   {% if options.alignment == 'horizontal' %}*/
/*     {% for row in items %}*/
/*       */
/*       {% if gva_masonry.class == '' %}*/
/*         <div{{ row.attributes.addClass(row_classes, options.row_class_default ? 'row-' ~ loop.index) }}>*/
/*       {% endif %}  */
/* */
/*         {% for column in row.content %}*/
/*           <div{{ column.attributes.addClass(col_classes, options.col_class_default ? 'col-' ~ loop.index, xclass, gva_masonry.class_item) }}>*/
/*             {{ column.content }}*/
/*           </div>*/
/*         {% endfor %}*/
/*       */
/*       {% if gva_masonry.class == '' %}*/
/*         </div>*/
/*       {% endif %}  */
/*     {% endfor %}*/
/*   {% else %}*/
/*     {% for column in items %}*/
/*       <div{{ column.attributes.addClass(col_classes, options.col_class_default ? 'col-' ~ loop.index, xclass) }}>*/
/*         {% for row in column.content %}*/
/*           <div{{ row.attributes.addClass(row_classes, options.row_class_default ? 'row-' ~ loop.index) }}>*/
/*             {{ row.content }}*/
/*           </div>*/
/*         {% endfor %}*/
/*       </div>*/
/*     {% endfor %}*/
/*   {% endif %}*/
/* </div>*/
