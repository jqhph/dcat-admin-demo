<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ !empty($title) ? $title . ' - ' : null }}{{ \DcatPage\config('website.title') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="{!! \DcatPage\config('website.description') !!}">
    <meta name="keywords" content="{{ \DcatPage\config('website.keywords') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($canonical))
        <link rel="canonical" href="{{ \DcatPage\url($canonical) }}" />
    @endif

    {!! \DcatPage\html_css('assets/css/laravel.css') !!}
    {!! \DcatPage\html_css('https://cdnjs.cloudflare.com/ajax/libs/flexboxgrid/6.3.1/flexboxgrid.min.css') !!}
    {!! \DcatPage\html_css('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i') !!}
    {!! \DcatPage\html_css('assets/font-awesome/css/font-awesome.min.css') !!}

    @if(DcatPage\config('comment.enable'))
        {!! \DcatPage\html_css('assets/gitalk/gitalk.css') !!}
    @endif

</head>
<body class="@yield('body-class', 'docs') language-default">
    {{--<div class="laracon-banner">--}}
        {{--<img src="/assets/svg/laracon-logo.svg" alt="">--}}
        {{--Laracon EU tickets are now available!--}}
        {{--<a href="https://laracon.eu">Get your tickets today!</a>--}}
    {{--</div>--}}
    <span class="overlay"></span>

    <nav class="main">
        <a href="{{\DcatPage\url('/')}}" class="brand nav-block">
            <span>Dcat Page</span>
        </a>

        <ul class="main-nav">
            @include(\DcatPage\view_name('partials.main-nav'))
        </ul>

        <div class="search nav-block invisible">
            <img src="{!! \DcatPage\svg('search') !!}" />
            <input placeholder="search" type="text" id="search-input" aria-label="search"/>
        </div>

        @if (isset($showSwitcher))
            @include(\DcatPage\view_name('partials.switcher'))
        @endif

        <div class="responsive-sidebar-nav">
            <a href="#" class="toggle-slide menu-link btn">&#9776;</a>
        </div>
    </nav>

    @yield('content')

    <footer class="main">
        <ul>
            @include(\DcatPage\view_name('partials.main-nav'))
        </ul>
        <p>Built by <b>{{ join(', ',array_column((array)\DcatPage\config('authors'), 'name') )}}</b>. Copyright &copy; 2019</p>
        <p class="less-significant">
            <a href="http://jackmcdade.com">
                Designed by<br>
                {!! \DcatPage\svg('jack-mcdade') !!}
            </a>
        </p>
    </footer>

    <div class="fixed-bottom-btn"><a class="waves-effect waves-light" id="go-top"><i class="fa fa-chevron-up"></i></a></div>

    @include(\DcatPage\view_name('partials.script'))

    @if(DcatPage\config('comment.enable'))
        {!! \DcatPage\html_js('assets/gitalk/gitalk.min.js') !!}
    @endif
    {!! \DcatPage\html_js('/assets/js/laravel.js') !!}
    {!! \DcatPage\html_js('/assets/js/viewport-units-buggyfill.js') !!}
    <script>window.viewportUnitsBuggyfill.init();</script>

</body>
</html>
