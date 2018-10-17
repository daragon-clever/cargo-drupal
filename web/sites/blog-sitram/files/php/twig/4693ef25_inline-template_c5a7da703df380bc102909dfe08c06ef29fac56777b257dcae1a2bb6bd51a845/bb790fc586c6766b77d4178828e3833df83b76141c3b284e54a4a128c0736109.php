<?php

/* {# inline_template_start #}<div class="post-block">
      <div class="post-image">
            {{field_image}}
      </div>
      <div class="post-content">
             <div class="post-title"> {{ title }} </div>
              <div class="post-meta"><span class="post-created ">{{ created }}</span></div>
             <div class="post-body">{{ body }}</div>
       </div>
</div> */
class __TwigTemplate_4904c69ebd0974cf9c4c145cca7c5c06a5da6eb8bcbc2449ec8460268769ebfe extends Twig_Template
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
             <div class=\"post-title\"> ";
        // line 6
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
        echo " </div>
              <div class=\"post-meta\"><span class=\"post-created \">";
        // line 7
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
        return "{# inline_template_start #}<div class=\"post-block\">
      <div class=\"post-image\">
            {{field_image}}
      </div>
      <div class=\"post-content\">
             <div class=\"post-title\"> {{ title }} </div>
              <div class=\"post-meta\"><span class=\"post-created \">{{ created }}</span></div>
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
        return array (  70 => 8,  66 => 7,  62 => 6,  56 => 3,  52 => 1,);
    }
}
/* {# inline_template_start #}<div class="post-block">*/
/*       <div class="post-image">*/
/*             {{field_image}}*/
/*       </div>*/
/*       <div class="post-content">*/
/*              <div class="post-title"> {{ title }} </div>*/
/*               <div class="post-meta"><span class="post-created ">{{ created }}</span></div>*/
/*              <div class="post-body">{{ body }}</div>*/
/*        </div>*/
/* </div>*/
