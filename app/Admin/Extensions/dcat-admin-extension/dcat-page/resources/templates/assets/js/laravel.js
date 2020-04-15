// jQuery core
window.jQuery = window.$ = require('./vendor/jquery.js');
window.__ENV__ = process.env.NODE_ENV;

// These all require jQuery
require('./vendor/prism.js');
require('./vendor/bootstrap.js');

const doc = require('./views/doc.js');
const search = require('./views/search.js');
const slide = require('./views/slide-menu.js');

jQuery(function($) {
  // Smooth scroll to anchor
  $('body.home a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });

    var $top = $('#go-top');
    // 滚动锚点
    $(window).scroll(function () {
        if (!window.matchMedia("(min-width: 960px)").matches) {
            // 与scotchPanel插件不兼容，手机页不显示回到顶部按钮
            $top.hide();
            return;
        }

        var scrollTop = $(this).scrollTop(), // 滚动条距离顶部的高度
            windowHeight = $(this).height();  // 当前可视的页面高度
        // 显示或隐藏滚动锚点
        if(scrollTop + windowHeight >= 1100) {
            $top.show(20)
        } else {
            $top.hide()
        }
    });
    // 滚动至顶部
    $top.click(function () {
        $("html, body").animate({
            scrollTop: $("body").offset().top
        }, {duration: 500, easing: "swing"});
        return false;
    });

    // gitalk
    if (
        $('#comment-container').length
        && typeof DcatPageconfig.comment != 'undefined'
        && DcatPageconfig.comment.enable
    ) {
        var gitalk = new Gitalk($.extend({
            id: location.pathname, // Ensure uniqueness and length less than 50
            distractionFreeMode: false,  // Facebook-like distraction free mode
        }, DcatPageconfig.comment || {}));

        gitalk.render('comment-container');
    }

  doc.init();
  search.init();
  slide.init();

});
