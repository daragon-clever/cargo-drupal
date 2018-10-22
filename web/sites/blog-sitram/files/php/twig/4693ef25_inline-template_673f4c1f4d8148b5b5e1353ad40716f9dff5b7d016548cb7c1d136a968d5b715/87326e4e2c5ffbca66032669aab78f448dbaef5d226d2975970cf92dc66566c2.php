<?php

/* {# inline_template_start #}<div class="post-block {{ field_taxonomy_color }}">
      <div class="post-image">
            {{field_image}}
      </div>
      <div class="post-content">
             <div class="post-title"> {{ title }} </div>
              <div class="post-meta"><span class="post-author">{{ field_full_name}}</span> - <span class="post-created ">{{ created }}</span></div>
             <div class="post-body">{{ body }}</div>
       </div>
</div> */
class __TwigTemplate_ded6fc9d45c48ebfb49263f4bb553caed9cf052e1fca316a4840befd518376b5 extends Twig_Template
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
        echo "<div class=\"post-block ";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_taxonomy_color"]) ? $context["field_taxonomy_color"] : null), "html", null, true));
        echo "\">
      <div class=\"post-image\">
            ";
        // line 3
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_image"]) ? $context["field_image"] : null), "html", null, true));
        echo "
      </div>
      <div class=\"post-content\">
             <div class=\"post-title\"> ";
        // line 6
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
        echo " </div>
              <div class=\"post-meta\"><span class=\"post-author\">";
        // line 7
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_full_name"]) ? $context["field_full_name"] : null), "html", null, true));
        echo "</span> - <span class=\"post-created \">";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["created"]) ? $context["created"] : null), "html", null, true));
        echo "</span></div>
             <div class=\"post-body\">";
        // line 8
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["body"]) ? $context["body"] : null), "html", null, true));
        echo "</div>
       </div>
</div>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<div class=\"post-block {{ field_taxonomy_color }}\">
      <div class=\"post-image\">
            {{field_image}}
      </div>
      <div class=\"post-content\">
             <div class=\"post-title\"> {{ title }} </div>
              <div class=\"post-meta\"><span class=\"post-author\">{{ field_full_name}}</span> - <span class=\"post-created \">{{ created }}</span></div>
             <div class=\"post-body\">{{ body }}</div>
       </div>
</div>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 8,  68 => 7,  64 => 6,  58 => 3,  52 => 1,);
    }
}
/* {# inline_template_start #}<div class="post-block {{ field_taxonomy_color }}">*/
/*       <div class="post-image">*/
/*             {{field_image}}*/
/*       </div>*/
/*       <div class="post-content">*/
/*              <div class="post-title"> {{ title }} </div>*/
/*               <div class="post-meta"><span class="post-author">{{ field_full_name}}</span> - <span class="post-created ">{{ created }}</span></div>*/
/*              <div class="post-body">{{ body }}</div>*/
/*        </div>*/
/* </div>*/
