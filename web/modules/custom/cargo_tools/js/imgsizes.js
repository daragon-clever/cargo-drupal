jQuery(document).ready(function ($) {
    // suppression du cookie
    if (window.location.href.indexOf("imgsizes=off") !== -1) {
        Cookies.remove('dimsCookie')
    }

    if (window.location.href.indexOf("imgsizes=on") !== -1 || Cookies.get('dimsCookie')) {
        // création du cookie
        if (!Cookies.get('dimsCookie')) {
            let cookieValue = Math.random();
            Cookies.set('dimsCookie', cookieValue, {expires: 1});
        }

        // mise à jour source - balises <img>
        $('img').map(function () {
            let placeHolder, imgH, imgW
            // cas particulier -- slick
            if ($(this).parents().attr("tabindex") && $(this).attr("height") && $(this).attr("width")) {
                imgH = $(this).attr("height")
                imgW = $(this).attr("width")
            } else {
                if ($(this).get(0).naturalHeight || $(this).get(0).naturalWidth) {
                    // cas général
                    imgH = $(this).get(0).naturalHeight
                    imgW = $(this).get(0).naturalWidth
                } else {
                    // cas particulier -- images sans dims définies
                    imgH = Math.floor($(this).height())
                    imgW = Math.floor($(this).width())
                }
            }
            placeHolder = 'https://via.placeholder.com/' + imgW + 'x' + imgH;
            $(this).attr("src", placeHolder)
        });

        // mise à jour source -- cas particulier slider HP Sitram
        $('picture source').map(function () {
            let sourceDims = new Image();
            sourceDims.src = $('picture source').attr("srcset");
            setTimeout(function () {
                let placeHolder = 'https://via.placeholder.com/' + sourceDims.width + 'x' + sourceDims.height
                $('picture source').attr("srcset", placeHolder)
            }, 500)
        });

        // mise à jour background image balises <div>, <span>, <a>
        $('div, span, a').map(function () {
            if ($(this).css("backgroundImage").includes("url")) {
                let backgroundDims = new Image();
                backgroundDims.src = $(this).css("backgroundImage").replace(/url\((['"])?(.*?)\1\)/gi, '$2').split(',')[0];
                if (!backgroundDims.width || !backgroundDims.height) {
                    backgroundDims.width = Math.floor($(this).width())
                    backgroundDims.height = Math.floor($(this).height())
                }
                $(this).css({
                    backgroundImage: 'url("https://via.placeholder.com/' + backgroundDims.width + 'x' + backgroundDims.height + '")'
                })
            }
        });
    }
});