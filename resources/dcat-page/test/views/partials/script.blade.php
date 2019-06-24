<script>
    var DMS = {
        version: '{{ isset($currentVersion) ? $currentVersion : \DcatPage\default_version() }}',

        getDocUrl: function (doc) {
            var temp = '{{ \DcatPage\doc_url('{doc}', isset($currentVersion) ? $currentVersion : \DcatPage\default_version()) }}';

            return temp.replace('{doc}', doc);
        }
    };
    (function () {
        function indices() {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = '{{ \DcatPage\asset('assets/indices/'. (isset($currentVersion) ? $currentVersion : \DcatPage\default_version()) . '.js') }}';
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        }

        setTimeout(indices, 1);
    })();
    
</script>
