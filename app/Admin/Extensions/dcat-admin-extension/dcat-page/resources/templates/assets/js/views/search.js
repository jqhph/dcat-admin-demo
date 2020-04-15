
require('../vendor/typeahead.js');

// Standalone vendor libraries
const Mousetrap = require('../vendor/mousetrap.js');

const Query = require('./query.js').Query;

const index = new Query();

function init() {
    Mousetrap.bind('/', function(e) {
        e.preventDefault();
        $('#search-input').focus();
    });

    Mousetrap.bind(["ctrl+b", "command+b"], function(e) {
        e.preventDefault();
        $(".sidebar").find( "h2" ).addClass('is-active');
    });

    initDocSearch();

    // Fixes FOUC for the search box
    $('.search.invisible').removeClass('invisible');

    function initDocSearch() {
        var $searchInput = $('#search-input');
        var $mainNav = $('.main-nav');
        var $article = $('article');
        var notSwitch = $mainNav.is(':hidden');

        $(window).resize(function () {
            notSwitch = $mainNav.is(':hidden');
        });

        // Closes algolia results on blur
        $searchInput.blur(function () {
            $(this).val('');
        });

        // Hides main nav to widen algolia results
        $searchInput.on('input', function (event) {
            if (notSwitch) {
                return;
            }

            if (event.currentTarget.value !== '') {
                $mainNav.hide();
            } else {
                $mainNav.show();
            }
        });

        // typeahead datasets
        // https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md#datasets
        var datasets = [], hits_number = 0;

        datasets.push({
            source: function search(keyword, cb) {

                let hits = index.search(keyword);

                hits = hits.slice(0, 12);

                hits_number = hits.length;

                cb(hits);
            },
            templates: {
                //templates.suggestion.render.bind(templates.suggestion)
                  suggestion: function (item) {
                      var content = '',
                          d = '<span style="color:#ccc;">></span>',
                          size = 'style="font-size:15px"',
                          titles = [item.h2, item.h3, item.h4],
                          subTitles = [],
                          i;

                      if (item.content) {
                          content = `<div class="content">${item.content}</div>`;
                      }

                      for (i in titles) {
                          if (titles[i]) {
                              subTitles.push(`<span ${size}>${titles[i]}</span>`);
                          }
                      }


                      if (subTitles.length) {
                          subTitles = subTitles.join(` ${d} `);

                          subTitles = `<div class="sub-section">
        <div class="h2" style="font-size:17px">
            <span class="hash">#</span>  ${subTitles}
        </div>
    </div>`;
                      }

                      return `<div class="autocomplete-wrapper">
    <div style="font-size:16px;margin-bottom:5px">
        ${item.h1}
    </div>
    ${subTitles} ${content}
</div>`;
                  },
                  empty: function (p) {
                      var query = p.query;
                      return `<div class="autocomplete-wrapper empty"><div class="h2">We didn't find any result for "${query}". Sorry!</div></div>`;
                  }
            },

        });

        var typeahead = $searchInput.typeahead({hint: false}, datasets);
        var old_input = '';

        typeahead.on('typeahead:selected', function changePage(e, item) {
            window.location.href = DcatPagegetDocUrl(item.link) + (item.name ? `#${item.name}` : '');
        });

        typeahead.on('keyup', function(e) {
            old_input = $(this).typeahead('val');

            if ($(this).val() === '' && old_input.length == $(this).typeahead('val')) {
                $article.css('opacity', '1');
                $searchInput.closest('#search-wrapper').removeClass('not-empty');
            } else {
                $article.css('opacity', '0.1');
                $searchInput.closest('#search-wrapper').addClass('not-empty');
            }
            if (e.keyCode === 27) {
                $article.css('opacity', '1');
            }
        });

        typeahead.on('typeahead:closed', function () {
            $article.css('opacity', '1');
        });

        typeahead.on('typeahead:closed',
            function (e) {
                // keep menu open if input element is still focused
                if ($(e.target).is(':focus')) {
                    return false;
                }
            }
        );

        $('#cross').click(function() {
            typeahead.typeahead('val', '').keyup();
            $article.css('opacity', '1');
        });
    }
}

export {init}
