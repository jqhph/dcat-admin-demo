
function init() {

    var options = {
            max_width: '1440px',
        },
        $container = $('body article'),
        counter = {};

    if ($container.find('.the-404').length) {
        return;
    }

    var h2s = $container.find("h2");
    var h3s = $container.find("h3");
    var h4s = $container.find("h4");
    var h5s = $container.find("h5");

    var titles = {h2: h2s.length, h3: h3s.length, h4: h4s.length, h5: h5s.length},
        hTags = [];
    for (var i in titles) {
        if (titles[i] > 0) {
            hTags.push(i);
            counter[i] = 1;
        }
    }

    if (!hTags.length) {
        return;
    }

    function build () {
        if ($container.find('h1').length) {
            $container.find('h1').eq(0).after('<ul class="small-screen-toc"></ul>');
        } else {
            $container.prepend('<ul class="small-screen-toc"></ul>');
        }

        var $toc = $('.small-screen-toc');

        function setup_container() {
            if (!window.matchMedia(`(max-width:${options.max_width})`).matches) {
                $toc.hide();
                return;
            }
            $toc.show();
        }

        $container.find("h2,h3,h4,h5").each(function (i, item) {
            var id = '',
                tag = $(item).get(0).tagName.toLowerCase(),
                className = '',
                text = $(this).find('a').html() || $(this).html();

            hTags.forEach(function (title, i) {
                if (tag != title) {
                    return;
                }
                i++;
                counter[tag]++;

                id = title + '-' + i + '-' + counter[tag];
                className = 'item-h' + i;

                $(item).attr("id", "target" + id);
                $(item).addClass("target-name");

                $toc.append('<li><a class="' + className + '" onclick="return false;" href="#" link="#target' + id + '">' + text + '</a></li>');

            });

            setup_container();
        });

        $(window).on('resize', setup_container);

        $toc.find("a").click(function () {
            $("html,body").animate({scrollTop: $($(this).attr("link")).offset().top}, 500);
        });

    }

    build();

}

export {init}
