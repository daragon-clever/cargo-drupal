<style class="customize" type="text/css">
    <?php //================= Font Body Typography ====================== ?>
    <?php if(theme_get_setting('font_family_primary') && theme_get_setting('font_family_primary') != '---'){ ?>
        body,
        .gallery-post .post-meta-wrap .post-title a,
        .nav-tabs > li > a,
        .block.block-blocktabs .ui-widget, .block.block-blocktabs .ui-tabs-nav > li > a,
        .gva-mega-menu .block-blocktabs .ui-widget,.gva-mega-menu .block-blocktabs .ui-tabs-nav > li > a,
        .view-featured-videos .video-block .video-content .video-title a,
        .widget.gsc-call-to-action .title, .widget.milestone-block .milestone-text,
        .gsc-box-info .content .subtitle, .gsc-hover-box .box-title, .gsc-hover-background .front h2,
        .gsc-button,
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6
        {
            font-family: '<?php echo theme_get_setting('font_family_primary') ?>'!important;
        }
    <?php } ?> 

    <?php if(theme_get_setting('font_family_second') && theme_get_setting('font_family_second') != '---'){ ?>
        .categories-view-content.layout-big .post-link a,
        .posts-list-number .post-block .number, .posts-big .link a, .widget.gsc-heading .title-sub,
        .user-block .user-content .user-position, .comment-block .on
        {
            font-family: '<?php echo theme_get_setting('font_family_second') ?>'!important;
        }
    <?php } ?> 

    <?php if(theme_get_setting('font_body_size')){ ?>
        body{
            font-size: <?php echo (theme_get_setting('font_body_size') . 'px'); ?>;
        }
    <?php } ?>    

    <?php if(theme_get_setting('font_body_weight')){ ?>
        body{
            font-weight: <?php echo theme_get_setting('font_body_weight'); ?>;
        }
    <?php } ?>    

 
    <?php //================= Theme color primary ================== ?>
    <?php if(theme_get_setting('theme_color')){ ?>
        a:hover, a:focus,.btn-link:hover, .btn-link:focus,
        .pagination > li > a:hover, .pagination > li > a:focus,
        .pagination > li > span:hover,
        .pagination > li > span:focus,
        .topbar .topbar-right .social-list a:hover, .topbar .topbar-right .gva-search-region .icon,
        .topbar .topbar-right .gva-account-region .icon:hover, 
        .topbar .topbar-right .gva-account-region.show .icon, .breaking-news .item .post-title a:hover,
        .footer a:hover, ol.search-results > li p strong,
        .entry-readmore:hover, .video-block .image a:before, .video-block .image:hover a:before,
        .video-block .post-title a:hover, .category-block .name a:hover, .style-dark .post-block .post-title a:hover,
        .text-theme, .nav-tabs > li > a:hover, .nav-tabs > li > a:focus, .nav-tabs > li > a:active,
        .nav-tabs > li.active > a, .nav-tabs > li > a.active, .nav-tabs.drupal-tabs > li.is-active > a,
        .copyright-text .return-top:hover, .panel .panel-heading .panel-title > a:after,
        #user-login-form .form-actions input:hover, #user-login-form .form-actions input:focus, #user-login-form .form-actions input:active,
        #block-userlogin ul li a:hover, .block.style-higlight .more-link a:hover, .block.block-blocktabs .ui-tabs-nav > li.ui-tabs-active > a,
        nav.breadcrumb ol > li a:hover, .view-ajax-arrow-top .js-pager__items > li > *:hover ,
        .view-article-category-block .js-pager__items > li > *:hover,
        .view-slider-large .js-pager__items > li:hover,
        .view-slider-large .post-block .post-meta-wrap .post-title a:hover,
        .slider-hero .post-block .post-meta-wrap .post-title a:hover, 
        .view-featured-videos .video-block .video-content .video-title a:hover, 
        .view-featured-videos .video-block .video-content .icon a:hover,
        .posts-list-number .post-block .post-title a:hover, .posts-grid-hero .post-block .post-title a:hover,
        .widget.gsc-heading .title strong, .widget.gsc-call-to-action .title strong,
        .widget.gsc-team .team-position, .widget.gsc-icon-box a:hover, .widget.gsc-icon-box a:hover h4,
        .widget.gsc-icon-box .link a, .widget.gsc-icon-box.top-center .highlight-icon .icon, 
        .widget.gsc-icon-box.top-left .highlight-icon .icon, .widget.gsc-icon-box.top-left-title .highlight-icon .icon,
        .widget.gsc-icon-box.top-right-title .highlight-icon .icon, .widget.gsc-icon-box.top-right .highlight-icon .icon,
        .widget.gsc-icon-box.right .highlight-icon .icon, .widget.gsc-icon-box.left .highlight-icon .icon,
        .widget.milestone-block .milestone-icon span, .gsc-hover-box .icon span, .gsc-hover-box .link a,
        .gsc-hover-background .front .icon, .gsc-quote-text .icon, .gva-offcanvas-inner .offcanvas-close a,
        .gva-offcanvas-inner .gva-navigation .gva_menu > li > a:hover, .gva-offcanvas-inner .gva-navigation .gva_menu > li ul.menu.sub-menu li a:hover,
        .gva-offcanvas-inner .gva-navigation .gva_menu li a:hover
        {
            color: <?php echo theme_get_setting('theme_color') ?>!important;
        }

        
    <?php } ?>     


    <?php //================= Body page ===================== ?>
    <?php if(theme_get_setting('text_color')){ ?>
        body .body-page{
            color: <?php echo theme_get_setting('text_color') ?>;
        }
    <?php } ?>

    <?php if(theme_get_setting('link_color')){ ?>
        body .body-page a{
            color: <?php echo theme_get_setting('link_color') ?>!important;
        }
    <?php } ?>

    <?php if(theme_get_setting('link_hover_color')){ ?>
        body .body-page a:hover{
            color: <?php echo theme_get_setting('link_hover_color') ?>!important;
        }
    <?php } ?>

    <?php //===================Header=================== ?>
    <?php if(theme_get_setting('header_bg')){ ?>
        header .header-main{
            background: <?php echo theme_get_setting('header_bg') ?>!important;
        }
    <?php } ?>

    <?php if(theme_get_setting('header_color_link')){ ?>
        header .header-main a{
            background: <?php echo theme_get_setting('header_color_link') ?>!important;
        }
    <?php } ?>

    <?php if(theme_get_setting('header_color_link_hover')){ ?>
        header .header-main a:hover{
            background: <?php echo theme_get_setting('header_color_link_hover') ?>!important;
        }
    <?php } ?>

   <?php //===================Menu=================== ?>
    <?php if(theme_get_setting('menu_bg')){ ?>
        .main-menu, ul.gva_menu{
            background: <?php echo theme_get_setting('menu_bg') ?>!important;
        }
    <?php } ?> 

    <?php if(theme_get_setting('menu_color_link')){ ?>
        .main-menu ul.gva_menu > li > a{
            color: <?php echo theme_get_setting('menu_color_link') ?>!important;
        }
    <?php } ?> 

    <?php if(theme_get_setting('menu_color_link_hover')){ ?>
        .main-menu ul.gva_menu > li > a:hover{
            color: <?php echo theme_get_setting('menu_color_link_hover') ?>!important;
        }
    <?php } ?> 

    <?php if(theme_get_setting('submenu_background')){ ?>
        .main-menu .sub-menu{
            background: <?php echo theme_get_setting('submenu_background') ?>!important;
            color: <?php echo theme_get_setting('submenu_color') ?>!important;
        }
    <?php } ?> 

    <?php if(theme_get_setting('submenu_color')){ ?>
        .main-menu .sub-menu{
            color: <?php echo theme_get_setting('submenu_color') ?>!important;
        }
    <?php } ?> 

    <?php if(theme_get_setting('submenu_color_link')){ ?>
        .main-menu .sub-menu a{
            color: <?php echo theme_get_setting('submenu_color_link') ?>!important;
        }
    <?php } ?> 

    <?php if(theme_get_setting('submenu_color_link_hover')){ ?>
        .main-menu .sub-menu a:hover{
            color: <?php echo theme_get_setting('submenu_color_link_hover') ?>!important;
        }
    <?php } ?> 

    <?php //===================Footer=================== ?>
    <?php if(theme_get_setting('footer_bg') ){ ?>
        .footer{
            background: <?php echo theme_get_setting('footer_bg') ?>!important;
        }
    <?php } ?>

     <?php if(theme_get_setting('footer_color') ){ ?>
        .footer{
            color: <?php echo theme_get_setting('footer_color') ?> !important;
        }
    <?php } ?>

    <?php if(theme_get_setting('footer_color_link')){ ?>
        .footer ul.menu > li a::after, .footer a{
            color: <?php echo theme_get_setting('footer_color_link') ?>!important;
        }
    <?php } ?>    

    <?php if(theme_get_setting('footer_color_link_hover')){ ?>
        .footer a:hover{
            color: <?php echo theme_get_setting('footer_color_link_hover') ?> !important;
        }
    <?php } ?>    

    <?php //===================Copyright======================= ?>
    <?php if(theme_get_setting('copyright_bg')){ ?>
        .copyright{
            background: <?php echo theme_get_setting('copyright_bg') ?> !important;
        }
    <?php } ?>

     <?php if(theme_get_setting('copyright_color')){ ?>
        .copyright{
            color: <?php echo $customize['copyright_color'] ?> !important;
        }
    <?php } ?>

    <?php if(theme_get_setting('copyright_color_link')){ ?>
        .copyright a{
            color: <?php echo theme_get_setting('copyright_color_link') ?>!important;
        }
    <?php } ?>    

    <?php if(theme_get_setting('copyright_color_link_hover')){ ?>
        .copyright a:hover{
            color: <?php echo theme_get_setting('copyright_color_link_hover') ?> !important;
        }
    <?php } ?>
</style>
