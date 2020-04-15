
const Fuse = require('../vendor/fuse.js');

var Query = (function () {
    var version = DcatPageversion,
        placeholder = '⋆',
        indices = [],
        loaded,
        FuseIndex;

    var cacheKey = 'dcat-cms-indices-'+version;

    function Query(options) {
        this.options = $.extend({
            shouldSort: true,
            includeMatches: true,
            threshold: 0.8,
            location: 0,
            tokenize: true,
            matchAllTokens: true,
            distance: 100,
            maxPatternLength: 10000,
            minMatchCharLength: 2,
            includeScore: true,
            findAllMatches: true,
            keys: [
                "h2",
                "h3",
                "h4",
                "content",
            ]
        }, options);
    }

    // 搜索
    Query.prototype.search = function (keyword) {
        if (!keyword) return false;

        var fuse = FuseIndex ? FuseIndex : new Fuse(this.buildIndices(), this.options);
        if (loaded) {
            FuseIndex = fuse;
        }

        var result = fuse.search(keyword.trim());

        var hits = [];

        result.forEach(function (val) {
            var matches = $.extend(val.matches, []), hit = {
                h1: val.item.h1,
                link: val.item.link,
                h2: val.item.h2,
                h3: val.item.h3,
                h4: val.item.h4 || null,
                content: val.item.content,
                name: val.item.name,
            };
            if (!matches || !matches.length) {
                return;
            }

            matches.forEach(function (match) {
                var value = match.value,
                    words = [],
                    skip = [],
                    offset = 0,
                    startLen = match.indices[0][0],
                    endLen = 0;

                match.indices = match.indices.slice(0, 5); // 最多只显示5个搜索字段
                match.indices.forEach(function (indices) {
                    var start = indices[0] + offset,
                        end = indices[1] + offset,
                        distance = start - endLen,
                        word;

                    // 缩减多余内容
                    if (distance > 80) {
                        let mid = Math.ceil(distance / 4);
                        let midStart = endLen + distance / 2 - mid,
                            midEnd = midStart + mid * 2;

                        skip.push(midEnd - midStart);

                        value = set_placeholder(value, midStart, midEnd, repeat('?', midEnd - midStart - 1));
                    }

                    endLen = end;

                    // 把关键词替换为占位符
                    words.push(word = value.slice(start, end + 1));
                    value = set_placeholder(value, start, end, word);

                    offset += 2;
                });

                // 高亮显示关键词
                words.forEach(function (word) {
                    var replace = '<em>' + word + '</em>';
                    value = value.replace(placeholder+word+placeholder, replace);
                });

                let valLen = value.length, maxLen = 500, moreL = 180, stopLen = endLen + moreL;
                if (valLen > maxLen) {
                    if (stopLen < maxLen) {
                        stopLen = maxLen;
                    }

                    value = value.slice(0, stopLen) + ' <b>...</b> ';
                }

                // 省略中间多余的字数
                skip.forEach(function (len) {
                    var reg = new RegExp(`${placeholder}{1}[\?]+${placeholder}{1}`);
                    value = value.replace(reg, ' <b>...</b> ');
                });

                // 把搜索选中的文档替换为高亮后文档
                hit[match.key] = value;

            });

            hits.push(hit);

        });

        return hits;

        function set_placeholder (str, start, end, keyword) {
            if (!str) {
                return str;
            }
            var replace = placeholder + keyword + placeholder;

            return str.slice(0, start) + replace + str.slice(end + 1, str.length);
        }

        function repeat(str, num) {
            var i, result = '';
            for (i = 0; i < num; i++) {
                result += str;
            }
            return result;
        }
    };

    // 构建索引
    Query.prototype.buildIndices = function () {
        // 需要转化为二维数组
        var docs = [];
        for (var i = 0; i < indices.length; i++) {
            for (var j = 0; j < indices[i].nodes.length; j++) {
                var node = indices[i].nodes[j];

                node.h1 = indices[i].title;
                node.link = indices[i].link;
                node.content = htmlspecialchars(node.content);
                docs.push(node);
            }
        }

        return docs;
    };

    function htmlspecialchars(str) {
        // str = str.replace(/&/g, '&amp;');
        str = str.replace(/</g, '&lt;');
        // str = str.replace(/>/g, '&gt;');
        str = str.replace(/"/g, '&quot;');
        str = str.replace(/'/g, '&#039;');
        return str;
    }

    // 加载索引
    var set_indices = function () {
        if (loaded) {
            return;
        }
        setTimeout(set_indices, 500);

        if (window.CURRENT_INDICES) {
            indices = window.CURRENT_INDICES;
            loaded = true;

            localStorage.setItem(cacheKey, JSON.stringify(indices || []));
        }
    };

    // 初始化
    function init() {
        indices = localStorage.getItem(cacheKey) || '[]';
        indices = JSON.parse(indices);

        set_indices();

        return Query;
    }

    return init();
})();

export {Query};
