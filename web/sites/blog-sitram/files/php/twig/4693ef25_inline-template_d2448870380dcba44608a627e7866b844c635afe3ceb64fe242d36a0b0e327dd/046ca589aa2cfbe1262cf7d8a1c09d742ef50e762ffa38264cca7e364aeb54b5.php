<?php

/* {# inline_template_start #}<div class="post-slider post-block">
   <div class="post-inner">
	  <div class="image">
			{{ field_image }}
	  </div>
	  <div class="post-meta-wrap">
		 	<div class="post-meta top no-margin">
			 	<div class="post-categories categories-before {{field_taxonomy_color}}">
					{{ field_post_category }} 
			 	</div>
			</div>
		 	<div class="post-title">
				{{ title }}
		 	</div>
		 <div class="post-meta">
			<span class="post-author">{{field_full_name}} </span> - <span class="date">{{ created }}</span>
		 </div>
	  </div>
   </div>
</div>
 */
class __TwigTemplate_738b5ec32457da283838a5476548febfee0fa718fda426ee1f02a79e1f0647e2 extends Twig_Template
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
        echo "<div class=\"post-slider post-block\">
   <div class=\"post-inner\">
\t  <div class=\"image\">
\t\t\t";
        // line 4
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_image"]) ? $context["field_image"] : null), "html", null, true));
        echo "
\t  </div>
\t  <div class=\"post-meta-wrap\">
\t\t \t<div class=\"post-meta top no-margin\">
\t\t\t \t<div class=\"post-categories categories-before ";
        // line 8
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_taxonomy_color"]) ? $context["field_taxonomy_color"] : null), "html", null, true));
        echo "\">
\t\t\t\t\t";
        // line 9
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_post_category"]) ? $context["field_post_category"] : null), "html", null, true));
        echo " 
\t\t\t \t</div>
\t\t\t</div>
\t\t \t<div class=\"post-title\">
\t\t\t\t";
        // line 13
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
        echo "
\t\t \t</div>
\t\t <div class=\"post-meta\">
\t\t\t<span class=\"post-author\">";
        // line 16
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_full_name"]) ? $context["field_full_name"] : null), "html", null, true));
        echo " </span> - <span class=\"date\">";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["created"]) ? $context["created"] : null), "html", null, true));
        echo "</span>
\t\t </div>
\t  </div>
   </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<div class=\"post-slider post-block\">
   <div class=\"post-inner\">
\t  <div class=\"image\">
\t\t\t{{ field_image }}
\t  </div>
\t  <div class=\"post-meta-wrap\">
\t\t \t<div class=\"post-meta top no-margin\">
\t\t\t \t<div class=\"post-categories categories-before {{field_taxonomy_color}}\">
\t\t\t\t\t{{ field_post_category }} 
\t\t\t \t</div>
\t\t\t</div>
\t\t \t<div class=\"post-title\">
\t\t\t\t{{ title }}
\t\t \t</div>
\t\t <div class=\"post-meta\">
\t\t\t<span class=\"post-author\">{{field_full_name}} </span> - <span class=\"date\">{{ created }}</span>
\t\t </div>
\t  </div>
   </div>
</div>
";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 16,  86 => 13,  79 => 9,  75 => 8,  68 => 4,  63 => 1,);
    }
}
/* {# inline_template_start #}<div class="post-slider post-block">*/
/*    <div class="post-inner">*/
/* 	  <div class="image">*/
/* 			{{ field_image }}*/
/* 	  </div>*/
/* 	  <div class="post-meta-wrap">*/
/* 		 	<div class="post-meta top no-margin">*/
/* 			 	<div class="post-categories categories-before {{field_taxonomy_color}}">*/
/* 					{{ field_post_category }} */
/* 			 	</div>*/
/* 			</div>*/
/* 		 	<div class="post-title">*/
/* 				{{ title }}*/
/* 		 	</div>*/
/* 		 <div class="post-meta">*/
/* 			<span class="post-author">{{field_full_name}} </span> - <span class="date">{{ created }}</span>*/
/* 		 </div>*/
/* 	  </div>*/
/*    </div>*/
/* </div>*/
/* */
