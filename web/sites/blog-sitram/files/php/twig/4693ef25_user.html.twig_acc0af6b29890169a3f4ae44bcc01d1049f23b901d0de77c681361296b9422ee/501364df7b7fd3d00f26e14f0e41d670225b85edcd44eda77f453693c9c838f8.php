<?php

/* themes/gavias_great/templates/user/user.html.twig */
class __TwigTemplate_a712ad5f7ab2dc81de3d9713045160c1f68ea6ec4dd1c5e76cebdb65b9c1eab3 extends Twig_Template
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
        $tags = array("if" => 21);
        $filters = array("without" => 48);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
                array('without'),
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

        // line 19
        echo "<article";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => "profile user-profile"), "method"), "html", null, true));
        echo ">
   <div class=\"row\">
      ";
        // line 21
        if ((isset($context["user_content"]) ? $context["user_content"] : null)) {
            // line 22
            echo "         <div class=\"col-md-8 col-xs-12\">
            ";
            // line 23
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["user_content"]) ? $context["user_content"] : null), "html", null, true));
            echo "
         </div>
      ";
        }
        // line 26
        echo "
      ";
        // line 27
        if ((isset($context["user_content"]) ? $context["user_content"] : null)) {
            // line 28
            echo "         <div class=\"col-md-4 col-xs-12\">
      ";
        } else {
            // line 29
            echo "   
         <div class=\"col-md-12 col-xs-12\">
      ";
        }
        // line 31
        echo "   
         ";
        // line 32
        if ($this->getAttribute((isset($context["content"]) ? $context["content"] : null), "user_picture", array())) {
            // line 33
            echo "            <div class=\"user-picture\">
               ";
            // line 34
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "user_picture", array()), "html", null, true));
            echo "
            </div>
         ";
        }
        // line 36
        echo "    
         ";
        // line 37
        if ($this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_full_name", array())) {
            // line 38
            echo "            <div class=\"user-fullname\">
               ";
            // line 39
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_full_name", array()), "html", null, true));
            echo "
            </div>
         ";
        }
        // line 41
        echo "      
         ";
        // line 42
        if ($this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_user_position", array())) {
            // line 43
            echo "            <div class=\"user-position\">
               ";
            // line 44
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_user_position", array()), "html", null, true));
            echo "
            </div>
         ";
        }
        // line 46
        echo "     
         ";
        // line 47
        if ((isset($context["content"]) ? $context["content"] : null)) {
            // line 48
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, twig_without((isset($context["content"]) ? $context["content"] : null), "user_picture", "field_full_name", "field_user_position"), "html", null, true));
        }
        // line 50
        echo "      </div>
   </div>  
</article>
";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/user/user.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 50,  121 => 48,  119 => 47,  116 => 46,  110 => 44,  107 => 43,  105 => 42,  102 => 41,  96 => 39,  93 => 38,  91 => 37,  88 => 36,  82 => 34,  79 => 33,  77 => 32,  74 => 31,  69 => 29,  65 => 28,  63 => 27,  60 => 26,  54 => 23,  51 => 22,  49 => 21,  43 => 19,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Theme override to present all user data.*/
/*  **/
/*  * This template is used when viewing a registered user's page,*/
/*  * e.g., example.com/user/123. 123 being the user's ID.*/
/*  **/
/*  * Available variables:*/
/*  * - content: A list of content items. Use 'content' to print all content, or*/
/*  *   print a subset such as 'content.field_example'. Fields attached to a user*/
/*  *   such as 'user_picture' are available as 'content.user_picture'.*/
/*  * - attributes: HTML attributes for the container element.*/
/*  * - user: A Drupal User entity.*/
/*  **/
/*  * @see template_preprocess_user()*/
/*  *//* */
/* #}*/
/* <article{{ attributes.addClass('profile user-profile') }}>*/
/*    <div class="row">*/
/*       {% if user_content %}*/
/*          <div class="col-md-8 col-xs-12">*/
/*             {{user_content}}*/
/*          </div>*/
/*       {% endif %}*/
/* */
/*       {% if user_content %}*/
/*          <div class="col-md-4 col-xs-12">*/
/*       {% else %}   */
/*          <div class="col-md-12 col-xs-12">*/
/*       {% endif %}   */
/*          {% if content.user_picture %}*/
/*             <div class="user-picture">*/
/*                {{content.user_picture}}*/
/*             </div>*/
/*          {% endif %}    */
/*          {% if content.field_full_name %}*/
/*             <div class="user-fullname">*/
/*                {{content.field_full_name}}*/
/*             </div>*/
/*          {% endif %}      */
/*          {% if content.field_user_position %}*/
/*             <div class="user-position">*/
/*                {{content.field_user_position}}*/
/*             </div>*/
/*          {% endif %}     */
/*          {% if content %}*/
/*             {{- content|without('user_picture','field_full_name', 'field_user_position') -}}*/
/*          {% endif %}*/
/*       </div>*/
/*    </div>  */
/* </article>*/
/* */
