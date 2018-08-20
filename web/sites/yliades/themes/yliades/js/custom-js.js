jQuery(document).ready(function($) {
    if ($(".mea-marques").length) {
        $(".mea-marques").slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows:false,
                        centerMode: true
                    }
                }
            ]
        });
    }

    Drupal.Ajax.prototype.setProgressIndicatorFullscreen = function () {
        this.progress.element = $('<div class="ajax-progress ajax-progress-fullscreen loader"> </div>');
        $('.views-infinite-scroll-content-wrapper').append(this.progress.element);
    };

    Drupal.AjaxCommands.prototype = {
        insert: function insert(ajax, response, status) {
            var $wrapper = response.selector ? $(response.selector) : $(ajax.wrapper);
            var method = response.method || ajax.method;
            var effect = ajax.getEffect(response);
            var settings = void 0;

            if ($(".views-element-container").length) {
                var $newContentWrapped = $('.views-element-container').html(response.data);
            } else {
                var $newContentWrapped = $('<div></div>').html(response.data);
            }
            var $newContent = $newContentWrapped.contents();

            if ($newContent.length !== 1 || $newContent.get(0).nodeType !== 1) {
                $newContent = $newContentWrapped;
            }

            switch (method) {
                case 'html':
                case 'replaceWith':
                case 'replaceAll':
                case 'empty':
                case 'remove':
                    settings = response.settings || ajax.settings || drupalSettings;
                    Drupal.detachBehaviors($wrapper.get(0), settings);
            }

            //$wrapper[method]($newContent);

            if (effect.showEffect !== 'show') {
                $newContent.hide();
            }

            if ($newContent.find('.ajax-new-content').length > 0) {
                $newContent.find('.ajax-new-content').hide();
                $newContent.show();
                $newContent.find('.ajax-new-content')[effect.showEffect](effect.showSpeed);
            } else if (effect.showEffect !== 'show') {
                $newContent[effect.showEffect](effect.showSpeed);
            }

            if ($newContent.parents('html').length > 0) {
                settings = response.settings || ajax.settings || drupalSettings;
                Drupal.attachBehaviors($newContent.get(0), settings);
            }
        },
        remove: function remove(ajax, response, status) {
            var settings = response.settings || ajax.settings || drupalSettings;
            $(response.selector).each(function () {
                Drupal.detachBehaviors(this, settings);
            }).remove();
        },
        changed: function changed(ajax, response, status) {
            var $element = $(response.selector);
            if (!$element.hasClass('ajax-changed')) {
                $element.addClass('ajax-changed');
                if (response.asterisk) {
                    $element.find(response.asterisk).append(' <abbr class="ajax-changed" title="' + Drupal.t('Changed') + '">*</abbr> ');
                }
            }
        },
        alert: function alert(ajax, response, status) {
            window.alert(response.text, response.title);
        },
        redirect: function redirect(ajax, response, status) {
            window.location = response.url;
        },
        css: function css(ajax, response, status) {
            $(response.selector).css(response.argument);
        },
        settings: function settings(ajax, response, status) {
            var ajaxSettings = drupalSettings.ajax;

            if (ajaxSettings) {
                Drupal.ajax.expired().forEach(function (instance) {

                    if (instance.selector) {
                        var selector = instance.selector.replace('#', '');
                        if (selector in ajaxSettings) {
                            delete ajaxSettings[selector];
                        }
                    }
                });
            }

            if (response.merge) {
                $.extend(true, drupalSettings, response.settings);
            } else {
                ajax.settings = response.settings;
            }
        },
        data: function data(ajax, response, status) {
            $(response.selector).data(response.name, response.value);
        },
        invoke: function invoke(ajax, response, status) {
            var $element = $(response.selector);
            $element[response.method].apply($element, _toConsumableArray(response.args));
        },
        restripe: function restripe(ajax, response, status) {
            $(response.selector).find('> tbody > tr:visible, > tr:visible').removeClass('odd even').filter(':even').addClass('odd').end().filter(':odd').addClass('even');
        },
        update_build_id: function update_build_id(ajax, response, status) {
            $('input[name="form_build_id"][value="' + response.old + '"]').val(response.new);
        },
        add_css: function add_css(ajax, response, status) {
            $('head').prepend(response.data);

            var match = void 0;
            var importMatch = /^@import url\("(.*)"\);$/igm;
            if (document.styleSheets[0].addImport && importMatch.test(response.data)) {
                importMatch.lastIndex = 0;
                do {
                    match = importMatch.exec(response.data);
                    document.styleSheets[0].addImport(match[1]);
                } while (match);
            }
        }
    };

});