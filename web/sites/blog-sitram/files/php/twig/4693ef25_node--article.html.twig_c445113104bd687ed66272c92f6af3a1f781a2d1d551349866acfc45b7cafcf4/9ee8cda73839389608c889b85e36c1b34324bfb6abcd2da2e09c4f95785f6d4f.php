<?php

/* themes/gavias_great/templates/node/node--article.html.twig */
class __TwigTemplate_77e530a2331bd68f6b8f9f7e1303a0fbb2e51c98d41b57b306cb7fbe4111beba extends Twig_Template
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
        $tags = array("set" => 2, "if" => 15, "trans" => 86);
        $filters = array("clean_class" => 5, "raw" => 21, "without" => 93);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set', 'if', 'trans'),
                array('clean_class', 'raw', 'without'),
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

        // line 2
        $context["classes"] = array(0 => "node", 1 => "node-detail", 2 => ("node--type-" . \Drupal\Component\Utility\Html::getClass($this->getAttribute(        // line 5
(isset($context["node"]) ? $context["node"] : null), "bundle", array()))), 3 => (($this->getAttribute(        // line 6
(isset($context["node"]) ? $context["node"] : null), "isPromoted", array(), "method")) ? ("node--promoted") : ("")), 4 => (($this->getAttribute(        // line 7
(isset($context["node"]) ? $context["node"] : null), "isSticky", array(), "method")) ? ("node--sticky") : ("")), 5 => (( !$this->getAttribute(        // line 8
(isset($context["node"]) ? $context["node"] : null), "isPublished", array(), "method")) ? ("node--unpublished") : ("")), 6 => ((        // line 9
(isset($context["view_mode"]) ? $context["view_mode"] : null)) ? (("node--view-mode-" . \Drupal\Component\Utility\Html::getClass((isset($context["view_mode"]) ? $context["view_mode"] : null)))) : ("")), 7 => "clearfix");
        // line 13
        echo "
<!-- Start Display article for teaser page -->
";
        // line 15
        if (((isset($context["teaser"]) ? $context["teaser"] : null) == true)) {
            echo " 
  <article";
            // line 16
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => (isset($context["classes"]) ? $context["classes"] : null)), "method"), "html", null, true));
            echo ">
    <div class=\"post-block display-term\">
      
      <div class=\"post-thumbnail post-";
            // line 19
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["post_format"]) ? $context["post_format"] : null), "html", null, true));
            echo "\">
        ";
            // line 20
            if ((((isset($context["post_format"]) ? $context["post_format"] : null) == "video") || (((isset($context["post_format"]) ? $context["post_format"] : null) == "audio") && (isset($context["gva_iframe"]) ? $context["gva_iframe"] : null)))) {
                // line 21
                echo "          ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar((isset($context["gva_iframe"]) ? $context["gva_iframe"] : null)));
                echo "
        ";
            } elseif (((            // line 22
(isset($context["post_format"]) ? $context["post_format"] : null) == "gallery") && $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_post_gallery", array()))) {
                // line 23
                echo "          ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_post_gallery", array()), "html", null, true));
                echo "
        ";
            } else {
                // line 25
                echo "          ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_image", array()), "html", null, true));
                echo "
        ";
            }
            // line 26
            echo " 

        ";
            // line 29
            echo "        ";
            if ($this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_post_category", array())) {
                // line 30
                echo "          ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_post_category", array()), "html", null, true));
                echo "
        ";
            }
            // line 31
            echo " 
      </div>

      <div class=\"post-content\">
        ";
            // line 35
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_prefix"]) ? $context["title_prefix"] : null), "html", null, true));
            echo "
           <h3";
            // line 36
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["title_attributes"]) ? $context["title_attributes"] : null), "addClass", array(0 => "post-title"), "method"), "html", null, true));
            echo "><a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true));
            echo "\" rel=\"bookmark\">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["label"]) ? $context["label"] : null), "html", null, true));
            echo "</a></h3>
        ";
            // line 37
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_suffix"]) ? $context["title_suffix"] : null), "html", null, true));
            echo "         
        <div class=\"post-meta\">
          <span class=\"post-author\"> ";
            // line 39
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["author_name"]) ? $context["author_name"] : null), "html", null, true));
            echo " </span>
          <span class=\"space\">-</span>
          <span class=\"post-created\"> ";
            // line 41
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["date"]) ? $context["date"] : null), "html", null, true));
            echo " </span> 
        </div>
        <div class=\"post-body\">
          ";
            // line 44
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "body", array()), "html", null, true));
            echo "
        </div>
        <div class=\"post-link hidden\">
          <a href=\"";
            // line 47
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true));
            echo "\">Read more</a>
        </div>
      </div>

    </div>
  </article>  

<!-- End Display article for teaser page -->
";
        } else {
            // line 56
            echo "<!-- Start Display article for detail page -->

<article";
            // line 58
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => (isset($context["classes"]) ? $context["classes"] : null)), "method"), "html", null, true));
            echo ">
  <div class=\"post-block\">
      
    <div class=\"post-thumbnail post-";
            // line 61
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["post_format"]) ? $context["post_format"] : null), "html", null, true));
            echo "\">
      ";
            // line 62
            if ((((isset($context["post_format"]) ? $context["post_format"] : null) == "video") || (((isset($context["post_format"]) ? $context["post_format"] : null) == "audio") && (isset($context["gva_iframe"]) ? $context["gva_iframe"] : null)))) {
                // line 63
                echo "        ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar((isset($context["gva_iframe"]) ? $context["gva_iframe"] : null)));
                echo "
      ";
            } elseif (((            // line 64
(isset($context["post_format"]) ? $context["post_format"] : null) == "gallery") && $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_post_gallery", array()))) {
                // line 65
                echo "        ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_post_gallery", array()), "html", null, true));
                echo "
      ";
            } else {
                // line 67
                echo "        ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_image", array()), "html", null, true));
                echo "
      ";
            }
            // line 68
            echo "  
    </div>

    <div class=\"post-content\">
      <div>";
            // line 72
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_post_category", array()), "html", null, true));
            echo "</div>
      ";
            // line 73
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_prefix"]) ? $context["title_prefix"] : null), "html", null, true));
            echo "
         <h1";
            // line 74
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["title_attributes"]) ? $context["title_attributes"] : null), "addClass", array(0 => "post-title"), "method"), "html", null, true));
            echo ">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["label"]) ? $context["label"] : null), "html", null, true));
            echo "</h1>
      ";
            // line 75
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_suffix"]) ? $context["title_suffix"] : null), "html", null, true));
            echo "         
      <div class=\"post-meta\">
          <span class=\"post-author\"> ";
            // line 77
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["author_name"]) ? $context["author_name"] : null), "html", null, true));
            echo " </span>
          <span class=\"space\">-</span>
          <span class=\"post-created\"> ";
            // line 79
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["date"]) ? $context["date"] : null), "html", null, true));
            echo " </span> 
        </div>
      
      ";
            // line 82
            if ((isset($context["display_submitted"]) ? $context["display_submitted"] : null)) {
                // line 83
                echo "        <div class=\"node__meta hidden\">
          ";
                // line 84
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["author_picture"]) ? $context["author_picture"] : null), "html", null, true));
                echo "
          <span";
                // line 85
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["author_attributes"]) ? $context["author_attributes"] : null), "html", null, true));
                echo ">
            ";
                // line 86
                echo t("Submitted by @author_name on @date", array("@author_name" => (isset($context["author_name"]) ? $context["author_name"] : null), "@date" => (isset($context["date"]) ? $context["date"] : null), ));
                // line 87
                echo "          </span>
          ";
                // line 88
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["metadata"]) ? $context["metadata"] : null), "html", null, true));
                echo "
        </div>
      ";
            }
            // line 91
            echo "
      <div";
            // line 92
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content_attributes"]) ? $context["content_attributes"] : null), "addClass", array(0 => "node__content", 1 => "clearfix"), "method"), "html", null, true));
            echo ">
        ";
            // line 93
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, twig_without((isset($context["content"]) ? $context["content"] : null), "field_image", "field_post_category", "field_tags", "field_post_format", "field_post_type", "field_post_embed", "field_post_gallery", "field_taxonomy_color", "comment", "links"), "html", null, true));
            echo "
      </div>

      <div class=\"post-tags clearfix\">
        ";
            // line 97
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "field_tags", array()), "html", null, true));
            echo "
      </div>  

      <div class=\"related-posts margin-top-30\">
        ";
            // line 101
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["related_content"]) ? $context["related_content"] : null), "html", null, true));
            echo "
      </div>

      <div id=\"node-single-comment\">
        ";
            // line 105
            if (((isset($context["comment_count"]) ? $context["comment_count"] : null) > 0)) {
                echo " 
          <div class=\"comment-count\"><span>";
                // line 106
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["comment_count"]) ? $context["comment_count"] : null), "html", null, true));
                echo " Comments </span></div>
        ";
            }
            // line 107
            echo "  
        ";
            // line 108
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "comment", array()), "html", null, true));
            echo "
      </div>

    </div>

  </div>

</article>

<!-- End Display article for detail page -->
";
        }
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/node/node--article.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  289 => 108,  286 => 107,  281 => 106,  277 => 105,  270 => 101,  263 => 97,  256 => 93,  252 => 92,  249 => 91,  243 => 88,  240 => 87,  238 => 86,  234 => 85,  230 => 84,  227 => 83,  225 => 82,  219 => 79,  214 => 77,  209 => 75,  203 => 74,  199 => 73,  195 => 72,  189 => 68,  183 => 67,  177 => 65,  175 => 64,  170 => 63,  168 => 62,  164 => 61,  158 => 58,  154 => 56,  142 => 47,  136 => 44,  130 => 41,  125 => 39,  120 => 37,  112 => 36,  108 => 35,  102 => 31,  96 => 30,  93 => 29,  89 => 26,  83 => 25,  77 => 23,  75 => 22,  70 => 21,  68 => 20,  64 => 19,  58 => 16,  54 => 15,  50 => 13,  48 => 9,  47 => 8,  46 => 7,  45 => 6,  44 => 5,  43 => 2,);
    }
}
/* {%*/
/*   set classes = [*/
/*     'node',*/
/*     'node-detail',*/
/*     'node--type-' ~ node.bundle|clean_class,*/
/*     node.isPromoted() ? 'node--promoted',*/
/*     node.isSticky() ? 'node--sticky',*/
/*     not node.isPublished() ? 'node--unpublished',*/
/*     view_mode ? 'node--view-mode-' ~ view_mode|clean_class,*/
/*     'clearfix',*/
/*   ]*/
/* %}*/
/* */
/* <!-- Start Display article for teaser page -->*/
/* {% if teaser == true %} */
/*   <article{{ attributes.addClass(classes) }}>*/
/*     <div class="post-block display-term">*/
/*       */
/*       <div class="post-thumbnail post-{{ post_format }}">*/
/*         {% if post_format == 'video' or post_format == 'audio' and gva_iframe %}*/
/*           {{ gva_iframe|raw }}*/
/*         {% elseif post_format == 'gallery' and content.field_post_gallery %}*/
/*           {{ content.field_post_gallery }}*/
/*         {% else %}*/
/*           {{ content.field_image }}*/
/*         {% endif %} */
/* */
/*         {# Category #}*/
/*         {% if content.field_post_category %}*/
/*           {{ content.field_post_category }}*/
/*         {% endif %} */
/*       </div>*/
/* */
/*       <div class="post-content">*/
/*         {{ title_prefix }}*/
/*            <h3{{ title_attributes.addClass('post-title') }}><a href="{{ url }}" rel="bookmark">{{ label }}</a></h3>*/
/*         {{ title_suffix }}         */
/*         <div class="post-meta">*/
/*           <span class="post-author"> {{ author_name }} </span>*/
/*           <span class="space">-</span>*/
/*           <span class="post-created"> {{ date }} </span> */
/*         </div>*/
/*         <div class="post-body">*/
/*           {{ content.body }}*/
/*         </div>*/
/*         <div class="post-link hidden">*/
/*           <a href="{{url}}">Read more</a>*/
/*         </div>*/
/*       </div>*/
/* */
/*     </div>*/
/*   </article>  */
/* */
/* <!-- End Display article for teaser page -->*/
/* {% else %}*/
/* <!-- Start Display article for detail page -->*/
/* */
/* <article{{ attributes.addClass(classes) }}>*/
/*   <div class="post-block">*/
/*       */
/*     <div class="post-thumbnail post-{{ post_format }}">*/
/*       {% if post_format == 'video' or post_format == 'audio' and gva_iframe %}*/
/*         {{ gva_iframe|raw }}*/
/*       {% elseif post_format == 'gallery' and content.field_post_gallery %}*/
/*         {{ content.field_post_gallery }}*/
/*       {% else %}*/
/*         {{ content.field_image }}*/
/*       {% endif %}  */
/*     </div>*/
/* */
/*     <div class="post-content">*/
/*       <div>{{ content.field_post_category }}</div>*/
/*       {{ title_prefix }}*/
/*          <h1{{ title_attributes.addClass('post-title') }}>{{ label }}</h1>*/
/*       {{ title_suffix }}         */
/*       <div class="post-meta">*/
/*           <span class="post-author"> {{ author_name }} </span>*/
/*           <span class="space">-</span>*/
/*           <span class="post-created"> {{ date }} </span> */
/*         </div>*/
/*       */
/*       {% if display_submitted %}*/
/*         <div class="node__meta hidden">*/
/*           {{ author_picture }}*/
/*           <span{{ author_attributes }}>*/
/*             {% trans %}Submitted by {{ author_name }} on {{ date }}{% endtrans %}*/
/*           </span>*/
/*           {{ metadata }}*/
/*         </div>*/
/*       {% endif %}*/
/* */
/*       <div{{ content_attributes.addClass('node__content', 'clearfix') }}>*/
/*         {{ content|without('field_image', 'field_post_category', 'field_tags', 'field_post_format', 'field_post_type', 'field_post_embed', 'field_post_gallery','field_taxonomy_color' ,'comment', 'links') }}*/
/*       </div>*/
/* */
/*       <div class="post-tags clearfix">*/
/*         {{ content.field_tags }}*/
/*       </div>  */
/* */
/*       <div class="related-posts margin-top-30">*/
/*         {{ related_content }}*/
/*       </div>*/
/* */
/*       <div id="node-single-comment">*/
/*         {% if comment_count > 0 %} */
/*           <div class="comment-count"><span>{{ comment_count }} Comments </span></div>*/
/*         {% endif %}  */
/*         {{ content.comment }}*/
/*       </div>*/
/* */
/*     </div>*/
/* */
/*   </div>*/
/* */
/* </article>*/
/* */
/* <!-- End Display article for detail page -->*/
/* {% endif %}*/
