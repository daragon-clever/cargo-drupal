<?php

/* {# inline_template_start #}<div class="post-block">
      <div class="post-image post-thumbnail">
            {{ field_image }}
            <div class="post-categories categories-background {{ field_taxonomy_color }}">
                   {{ field_post_category }}
            </div>
            <div class="post-title">{{title}}</div>
             <div class="post-meta"><span class="post-author">{{ field_full_name }} </span> - <span class="post-created">{{ created }} </span></div>
      </div>
</div> */
class __TwigTemplate_252cba0e32b0818bcdbb17d15eeaf6ae3f77d8dd651450a403c2573c8f788ec0 extends Twig_Template
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
      <div class=\"post-image post-thumbnail\">
            ";
        // line 3
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_image"]) ? $context["field_image"] : null), "html", null, true));
        echo "
            <div class=\"post-categories categories-background ";
        // line 4
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_taxonomy_color"]) ? $context["field_taxonomy_color"] : null), "html", null, true));
        echo "\">
                   ";
        // line 5
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_post_category"]) ? $context["field_post_category"] : null), "html", null, true));
        echo "
            </div>
            <div class=\"post-title\">";
        // line 7
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
        echo "</div>
             <div class=\"post-meta\"><span class=\"post-author\">";
        // line 8
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_full_name"]) ? $context["field_full_name"] : null), "html", null, true));
        echo " </span> - <span class=\"post-created\">";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["created"]) ? $context["created"] : null), "html", null, true));
        echo " </span></div>
      </div>
</div>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<div class=\"post-block\">
      <div class=\"post-image post-thumbnail\">
            {{ field_image }}
            <div class=\"post-categories categories-background {{ field_taxonomy_color }}\">
                   {{ field_post_category }}
            </div>
            <div class=\"post-title\">{{title}}</div>
             <div class=\"post-meta\"><span class=\"post-author\">{{ field_full_name }} </span> - <span class=\"post-created\">{{ created }} </span></div>
      </div>
</div>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 8,  69 => 7,  64 => 5,  60 => 4,  56 => 3,  52 => 1,);
    }
}
/* {# inline_template_start #}<div class="post-block">*/
/*       <div class="post-image post-thumbnail">*/
/*             {{ field_image }}*/
/*             <div class="post-categories categories-background {{ field_taxonomy_color }}">*/
/*                    {{ field_post_category }}*/
/*             </div>*/
/*             <div class="post-title">{{title}}</div>*/
/*              <div class="post-meta"><span class="post-author">{{ field_full_name }} </span> - <span class="post-created">{{ created }} </span></div>*/
/*       </div>*/
/* </div>*/
