jQuery(document).ready(function ($) {
    if (window.location.href.indexOf("imgsizes") > -1) {
        $('img').map(function () {
            $(this).imagesLoaded(function () {
                let image = this.images[0].img;
                let imgH = image.naturalHeight;
                let imgW = image.naturalWidth;
                image.src = 'https://via.placeholder.com/' + imgW + 'x' + imgH;
            });
        });
    }
});