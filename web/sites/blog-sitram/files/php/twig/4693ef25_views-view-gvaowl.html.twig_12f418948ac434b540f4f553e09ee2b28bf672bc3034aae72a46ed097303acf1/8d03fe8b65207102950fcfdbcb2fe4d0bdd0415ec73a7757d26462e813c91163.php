<?php

/* modules/gavias_view/templates/views-view-gvaowl.html.twig */
class __TwigTemplate_ce8b00df4c9d784c463860c08a76755437d20793deefb2f983685b49a1084dd4 extends Twig_Template
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
        $tags = array("if" => 1, "for" => 9);
        $filters = array("raw" => 11);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if', 'for'),
                array('raw'),
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
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["attributes"]) ? $context["attributes"] : null), "html", null, true));
            echo ">
";
        }
        // line 4
        echo "   
   ";
        // line 5
        if ((isset($context["title"]) ? $context["title"] : null)) {
            // line 6
            echo "      <h3>";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
            echo "</h3>
   ";
        }
        // line 8
        echo "
    ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["rows"]) ? $context["rows"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 10
            echo "         <div class=\"item\">
            <div";
            // line 11
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute($context["row"], "attributes", array()), "html", null, true));
            echo ">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar($this->getAttribute($context["row"], "content", array())));
            echo "</div>
         </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "
";
        // line 15
        if ((isset($context["attributes"]) ? $context["attributes"] : null)) {
            // line 16
            echo "</div>
";
        }
    }

    public function getTemplateName()
    {
        return "modules/gavias_view/templates/views-view-gvaowl.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 16,  86 => 15,  83 => 14,  72 => 11,  69 => 10,  65 => 9,  62 => 8,  56 => 6,  54 => 5,  51 => 4,  45 => 2,  43 => 1,);
    }
}
/* {% if attributes -%}*/
/*    <div{{ attributes }}>*/
/* {% endif %}*/
/*    */
/*    {% if title %}*/
/*       <h3>{{ title }}</h3>*/
/*    {% endif %}*/
/* */
/*     {% for row in rows %}*/
/*          <div class="item">*/
/*             <div{{ row.attributes }}>{{ row.content|raw }}</div>*/
/*          </div>*/
/*     {% endfor %}*/
/* */
/* {% if attributes -%}*/
/*     </div>*/
/* {% endif %}*/
/* */
