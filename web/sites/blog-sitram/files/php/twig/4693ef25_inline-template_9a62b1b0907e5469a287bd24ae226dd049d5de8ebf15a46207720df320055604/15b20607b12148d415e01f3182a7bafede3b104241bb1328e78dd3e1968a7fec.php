<?php

/* {# inline_template_start #}<div class="post-block">
      <div class="post-image">
            {{field_image}}
      </div>
      <div class="post-content">
              <div class="post-meta top"><div class="post-categories categories-before {{field_taxonomy_color}}">{{field_post_category}}</div></div>
              <div class="post-title"> {{title}} </div>
       </div>
</div> */
class __TwigTemplate_5f434409c4ea3e2765a175d1389754d981df845e0436c20bac64207c33fdfc9f extends Twig_Template
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
      <div class=\"post-image\">
            ";
        // line 3
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_image"]) ? $context["field_image"] : null), "html", null, true));
        echo "
      </div>
      <div class=\"post-content\">
              <div class=\"post-meta top\"><div class=\"post-categories categories-before ";
        // line 6
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_taxonomy_color"]) ? $context["field_taxonomy_color"] : null), "html", null, true));
        echo "\">";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_post_category"]) ? $context["field_post_category"] : null), "html", null, true));
        echo "</div></div>
              <div class=\"post-title\"> ";
        // line 7
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
        echo " </div>
       </div>
</div>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<div class=\"post-block\">
      <div class=\"post-image\">
            {{field_image}}
      </div>
      <div class=\"post-content\">
              <div class=\"post-meta top\"><div class=\"post-categories categories-before {{field_taxonomy_color}}\">{{field_post_category}}</div></div>
              <div class=\"post-title\"> {{title}} </div>
       </div>
</div>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 7,  61 => 6,  55 => 3,  51 => 1,);
    }
}
/* {# inline_template_start #}<div class="post-block">*/
/*       <div class="post-image">*/
/*             {{field_image}}*/
/*       </div>*/
/*       <div class="post-content">*/
/*               <div class="post-meta top"><div class="post-categories categories-before {{field_taxonomy_color}}">{{field_post_category}}</div></div>*/
/*               <div class="post-title"> {{title}} </div>*/
/*        </div>*/
/* </div>*/
