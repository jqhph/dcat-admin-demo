require('../vendor/scotchPanels.js');

function init() {
    var scotchPanel = $('#slide-menu').scotchPanel({
        containerSelector: 'body',
        direction: 'left',
        duration: 300,
        transition: 'ease',
        distanceX: '70%',
        forceMinHeight: true,
        minHeight: '2500px',
        enableEscapeKey: true
    }).show(); // show to avoid flash of content

    setTimeout(function () {
        scotchPanel.find('.scotch-panel-canvas').css({transform: 'none'});
    }, 50);

    $('.toggle-slide').click(function() {
        scotchPanel.css('overflow', 'scroll');
        scotchPanel.toggle();
        return false;
    });

    $('.overlay').click(function() {
        // CLOSE ONLY
        scotchPanel.close();
    });

    // Hide the slide menu when changing the browser width

    function checkSize() {
        if (window.matchMedia("(min-width: 960px)").matches) {
            scotchPanel.close();
        }
    }

    checkSize();
    $(window).on('resize', checkSize);
}

export {init}
