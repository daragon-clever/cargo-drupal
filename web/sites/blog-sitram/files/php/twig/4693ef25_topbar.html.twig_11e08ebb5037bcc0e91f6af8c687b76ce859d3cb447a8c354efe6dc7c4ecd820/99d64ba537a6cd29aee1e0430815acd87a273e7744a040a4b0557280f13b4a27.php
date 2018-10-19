<?php

/* themes/gavias_great/templates/page/parts/topbar.html.twig */
class __TwigTemplate_62be7b19e6a9a6f6d7dc1ff71eea13a89991d3b881da8b3e5800252eaeb837a5 extends Twig_Template
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
        $tags = array("if" => 6);
        $filters = array("t" => 10, "raw" => 75);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
                array('t', 'raw'),
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
        echo "<div class=\"topbar\">
  <div class=\"container\">
    <div class=\"row\">
      
      <div class=\"topbar-left col-sm-6 col-xs-12 hidden-xs\">
        ";
        // line 6
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "breaking_news", array())) {
            // line 7
            echo "          <div class=\"breaking-news\">
            <div class=\"content-inner clearfix\">
              <div class=\"title\">
                 ";
            // line 10
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Breaking news")));
            echo "
              </div>
              <div class=\"content\">";
            // line 12
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "breaking_news", array()), "html", null, true));
            echo "</div> 
            </div> 
          </div>
        ";
        }
        // line 16
        echo "      </div>

      <div class=\"topbar-right col-sm-6 col-xs-12\">
        <div class=\"social-list\">
          ";
        // line 20
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "facebook", array())) {
            // line 21
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "facebook", array()), "html", null, true));
            echo "\"><i class=\"fa fa-facebook\"></i></a>
          ";
        }
        // line 22
        echo " 
          ";
        // line 23
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "twitter", array())) {
            // line 24
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "twitter", array()), "html", null, true));
            echo "\"><i class=\"fa fa-twitter-square\"></i></a>
          ";
        }
        // line 25
        echo " 
          ";
        // line 26
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "skype", array())) {
            // line 27
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "skype", array()), "html", null, true));
            echo "\"><i class=\"fa fa-skype\"></i></a>
          ";
        }
        // line 28
        echo " 
          ";
        // line 29
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "instagram", array())) {
            // line 30
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "instagram", array()), "html", null, true));
            echo "\"><i class=\"fa fa-instagram\"></i></a>
          ";
        }
        // line 31
        echo " 
          ";
        // line 32
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "dribbble", array())) {
            // line 33
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "dribbble", array()), "html", null, true));
            echo "\"><i class=\"fa fa-dribbble\"></i></a>
          ";
        }
        // line 34
        echo " 
          ";
        // line 35
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "linkedin", array())) {
            // line 36
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "linkedin", array()), "html", null, true));
            echo "\"><i class=\"fa fa-linkedin-square\"></i></a>
          ";
        }
        // line 37
        echo " 
          ";
        // line 38
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "pinterest", array())) {
            // line 39
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "pinterest", array()), "html", null, true));
            echo "\"><i class=\"fa fa-pinterest\"></i></a>
          ";
        }
        // line 40
        echo " 
          ";
        // line 41
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "google", array())) {
            // line 42
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "google", array()), "html", null, true));
            echo "\"><i class=\"fa fa-google-plus-square\"></i></a>
          ";
        }
        // line 43
        echo " 
          ";
        // line 44
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "youtube", array())) {
            // line 45
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "youtube", array()), "html", null, true));
            echo "\"><i class=\"fa fa-youtube-square\"></i></a>
          ";
        }
        // line 46
        echo " 
          ";
        // line 47
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "vimeo", array())) {
            // line 48
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "vimeo", array()), "html", null, true));
            echo "\"><i class=\"fa fa-vimeo-square\"></i></a>
          ";
        }
        // line 49
        echo "  
          ";
        // line 50
        if ($this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "tumblr", array())) {
            // line 51
            echo "            <a href=\"";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["custom_social_link"]) ? $context["custom_social_link"] : null), "tumblr", array()), "html", null, true));
            echo "\"><i class=\"fa fa-tumblr-square\"></i></a>
          ";
        }
        // line 52
        echo "  
        </div>  

        ";
        // line 55
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "search", array())) {
            // line 56
            echo "          <div class=\"gva-search-region search-region\">
            <span class=\"icon\"><i class=\"fa fa-search\"></i></span>
            <div class=\"search-content\">
              <a class=\"close\"><i class=\"fa fa-times\"></i></a> 
              <div class=\"content-inner\"> 
                ";
            // line 61
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "search", array()), "html", null, true));
            echo "
              </div>
            </div>  
          </div>
       ";
        }
        // line 66
        echo "
        <div class=\"gva-account-region hidden-xs\">
          <span class=\"icon\"><i class=\"fa fa-user\"></i></span>
          <div class=\"search-content\">
            <div class=\"content-inner\">  
              ";
        // line 71
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "account", array())) {
            // line 72
            echo "                ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "account", array()), "html", null, true));
            echo "
              ";
        } else {
            // line 74
            echo "                ";
            if ((isset($context["custom_account"]) ? $context["custom_account"] : null)) {
                // line 75
                echo "                  <div class=\"mess-login text-center\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar((isset($context["custom_account"]) ? $context["custom_account"] : null)));
                echo "</div>
                ";
            }
            // line 76
            echo "  
              ";
        }
        // line 77
        echo "  
            </div>  
          </div>  
        </div>

      </div>
    </div>
  </div>  
</div>
";
    }

    public function getTemplateName()
    {
        return "themes/gavias_great/templates/page/parts/topbar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  243 => 77,  239 => 76,  233 => 75,  230 => 74,  224 => 72,  222 => 71,  215 => 66,  207 => 61,  200 => 56,  198 => 55,  193 => 52,  187 => 51,  185 => 50,  182 => 49,  176 => 48,  174 => 47,  171 => 46,  165 => 45,  163 => 44,  160 => 43,  154 => 42,  152 => 41,  149 => 40,  143 => 39,  141 => 38,  138 => 37,  132 => 36,  130 => 35,  127 => 34,  121 => 33,  119 => 32,  116 => 31,  110 => 30,  108 => 29,  105 => 28,  99 => 27,  97 => 26,  94 => 25,  88 => 24,  86 => 23,  83 => 22,  77 => 21,  75 => 20,  69 => 16,  62 => 12,  57 => 10,  52 => 7,  50 => 6,  43 => 1,);
    }
}
/* <div class="topbar">*/
/*   <div class="container">*/
/*     <div class="row">*/
/*       */
/*       <div class="topbar-left col-sm-6 col-xs-12 hidden-xs">*/
/*         {% if page.breaking_news %}*/
/*           <div class="breaking-news">*/
/*             <div class="content-inner clearfix">*/
/*               <div class="title">*/
/*                  {{ 'Breaking news'|t }}*/
/*               </div>*/
/*               <div class="content">{{ page.breaking_news }}</div> */
/*             </div> */
/*           </div>*/
/*         {% endif %}*/
/*       </div>*/
/* */
/*       <div class="topbar-right col-sm-6 col-xs-12">*/
/*         <div class="social-list">*/
/*           {% if custom_social_link.facebook %}*/
/*             <a href="{{custom_social_link.facebook}}"><i class="fa fa-facebook"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.twitter %}*/
/*             <a href="{{custom_social_link.twitter}}"><i class="fa fa-twitter-square"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.skype %}*/
/*             <a href="{{custom_social_link.skype}}"><i class="fa fa-skype"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.instagram %}*/
/*             <a href="{{custom_social_link.instagram}}"><i class="fa fa-instagram"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.dribbble %}*/
/*             <a href="{{custom_social_link.dribbble}}"><i class="fa fa-dribbble"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.linkedin %}*/
/*             <a href="{{custom_social_link.linkedin}}"><i class="fa fa-linkedin-square"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.pinterest %}*/
/*             <a href="{{custom_social_link.pinterest}}"><i class="fa fa-pinterest"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.google %}*/
/*             <a href="{{custom_social_link.google}}"><i class="fa fa-google-plus-square"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.youtube %}*/
/*             <a href="{{custom_social_link.youtube}}"><i class="fa fa-youtube-square"></i></a>*/
/*           {% endif %} */
/*           {% if custom_social_link.vimeo %}*/
/*             <a href="{{custom_social_link.vimeo}}"><i class="fa fa-vimeo-square"></i></a>*/
/*           {% endif %}  */
/*           {% if custom_social_link.tumblr %}*/
/*             <a href="{{custom_social_link.tumblr}}"><i class="fa fa-tumblr-square"></i></a>*/
/*           {% endif %}  */
/*         </div>  */
/* */
/*         {% if page.search %}*/
/*           <div class="gva-search-region search-region">*/
/*             <span class="icon"><i class="fa fa-search"></i></span>*/
/*             <div class="search-content">*/
/*               <a class="close"><i class="fa fa-times"></i></a> */
/*               <div class="content-inner"> */
/*                 {{ page.search }}*/
/*               </div>*/
/*             </div>  */
/*           </div>*/
/*        {% endif %}*/
/* */
/*         <div class="gva-account-region hidden-xs">*/
/*           <span class="icon"><i class="fa fa-user"></i></span>*/
/*           <div class="search-content">*/
/*             <div class="content-inner">  */
/*               {% if page.account %}*/
/*                 {{ page.account }}*/
/*               {% else %}*/
/*                 {% if custom_account %}*/
/*                   <div class="mess-login text-center">{{custom_account|raw}}</div>*/
/*                 {% endif %}  */
/*               {% endif %}  */
/*             </div>  */
/*           </div>  */
/*         </div>*/
/* */
/*       </div>*/
/*     </div>*/
/*   </div>  */
/* </div>*/
/* */
