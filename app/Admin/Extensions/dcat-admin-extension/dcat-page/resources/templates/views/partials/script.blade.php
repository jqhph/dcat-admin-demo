@php
    $currentVersion = isset($currentVersion) ? $currentVersion : \DcatPage\default_version();
    $currentSection = isset($currentSection) ? $currentSection : null;
@endphp
<script>
    var DMS = {
        version: '{{ $currentVersion }}',

        getDocUrl: function (doc) {
            var temp = '{{ \DcatPage\doc_url('{doc}', $currentVersion) }}';

            if (location.pathname.indexOf(temp.replace('{doc}.html', '')) !== -1) {
                return doc+'.html';
            }

            return temp.replace('{doc}', doc);
        },

        config: {
            comment: {!! json_encode(\DcatPage\config('comment') ?: []) !!}
        },
    };

    DcatPageconfig.comment.id = '{{$currentVersion}}/{{trim($currentSection, '/')}}';

    (function () {
        function indices() {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = '{{ \DcatPage\asset('assets/indices/'. ($currentVersion) . '.js') }}';
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        }

        setTimeout(indices, 1);
    })();

</script>
