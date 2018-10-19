<?php

/* {# inline_template_start #}<div class="comment-block">
   <div class="info"><span class="author-name">{{name}}</span><span class="on"> on </span><span class="title">{{title}}</span></div>
   <div class="content">"{{subject}}"</div>
</div> */
class __TwigTemplate_c38d01f26f6f2a056efb769a43bc466c5cbdb41dc876b090297725be2ced1317 extends Twig_Template
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
        echo "<div class=\"comment-block\">
   <div class=\"info\"><span class=\"author-name\">";
        // line 2
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true));
        echo "</span><span class=\"on\"> on </span><span class=\"title\">";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
        echo "</span></div>
   <div class=\"content\">\"";
        // line 3
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["subject"]) ? $context["subject"] : null), "html", null, true));
        echo "\"</div>
</div>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<div class=\"comment-block\">
   <div class=\"info\"><span class=\"author-name\">{{name}}</span><span class=\"on\"> on </span><span class=\"title\">{{title}}</span></div>
   <div class=\"content\">\"{{subject}}\"</div>
</div>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 3,  49 => 2,  46 => 1,);
    }
}
/* {# inline_template_start #}<div class="comment-block">*/
/*    <div class="info"><span class="author-name">{{name}}</span><span class="on"> on </span><span class="title">{{title}}</span></div>*/
/*    <div class="content">"{{subject}}"</div>*/
/* </div>*/
